<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SwiftmailerBundle\DependencyInjection;

use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * SwiftmailerExtension is an extension for the SwiftMailer library.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SwiftmailerExtension extends Extension
{
    /**
     * Loads the Swift Mailer configuration.
     *
     * Usage example:
     *
     *      <swiftmailer:config transport="gmail">
     *        <swiftmailer:username>fabien</swift:username>
     *        <swiftmailer:password>xxxxx</swift:password>
     *        <swiftmailer:spool path="/path/to/spool/" />
     *      </swiftmailer:config>
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('swiftmailer.xml');

        if (class_exists(Application::class)) {
            $loader->load('console.xml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $mailers = [];
        foreach ($config['mailers'] as $name => $mailer) {
            $isDefaultMailer = $config['default_mailer'] === $name;
            $this->configureMailer($name, $mailer, $container, $isDefaultMailer);
            $mailers[$name] = sprintf('swiftmailer.mailer.%s', $name);
        }
        ksort($mailers);
        $container->setParameter('swiftmailer.mailers', $mailers);
        $container->setParameter('swiftmailer.default_mailer', $config['default_mailer']);

        $container->findDefinition('swiftmailer.data_collector')->addTag('data_collector', ['template' => '@Swiftmailer/Collector/swiftmailer.html.twig', 'id' => 'swiftmailer', 'priority' => 245]);

        $container->setAlias('mailer', 'swiftmailer.mailer');
        $container->getAlias('mailer')->setPublic(true);
    }

    protected function configureMailer($name, array $mailer, ContainerBuilder $container, $isDefaultMailer = false)
    {
        $definitionDecorator = $this->createChildDefinition('swiftmailer.transport.eventdispatcher.abstract');
        $container
            ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', $name), $definitionDecorator)
        ;

        $usedEnvs = null;
        $disableDelivery = isset($mailer['disable_delivery']) && $mailer['disable_delivery'];

        if (method_exists($container, 'resolveEnvPlaceholders')) {
            $options = [];
            $envVariablesAllowed = ['transport', 'url', 'username', 'password', 'host', 'port', 'timeout', 'source_ip', 'local_domain', 'encryption', 'auth_mode', 'command'];
            foreach ($envVariablesAllowed as $key) {
                $container->resolveEnvPlaceholders($mailer[$key], null, $usedEnvs);
                $options[$key] = $mailer[$key];
            }
        }
        if (!$usedEnvs) {
            SwiftmailerTransportFactory::validateConfig($mailer);
        }
        if ($usedEnvs && !$disableDelivery) {
            $transportId = sprintf('swiftmailer.mailer.%s.transport.dynamic', $name);
            $definitionDecorator = new Definition('\Swift_Transport');
            $definitionDecorator->setFactory(['Symfony\Bundle\SwiftmailerBundle\DependencyInjection\SwiftmailerTransportFactory', 'createTransport']);
            $definitionDecorator->setArguments([
                $options,
                new Reference('router.request_context', ContainerInterface::NULL_ON_INVALID_REFERENCE),
                new Reference(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', $name)),
            ]);
            $container->setDefinition(sprintf('swiftmailer.mailer.%s.transport.dynamic', $name), $definitionDecorator);
            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', $name), $transportId);

            $definitionDecorator = $this->createChildDefinition('swiftmailer.mailer.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s', $name), $definitionDecorator)
                ->replaceArgument(0, new Reference(sprintf('swiftmailer.mailer.%s.transport', $name)))
            ;

            $container->setParameter(sprintf('swiftmailer.mailer.%s.transport.name', $name), 'dynamic');
        } else {
            $mailer = SwiftmailerTransportFactory::resolveOptions($mailer);
            $transport = $disableDelivery ? 'null' : $mailer['transport'];

            $container->setParameter(sprintf('swiftmailer.mailer.%s.transport.name', $name), $transport);

            $transportId = \in_array($transport, ['smtp', 'sendmail', 'null'])
                ? sprintf('swiftmailer.mailer.%s.transport.%s', $name, $transport)
                : $transport;

            $this->configureMailerTransport($name, $mailer, $container, $transport, $isDefaultMailer);
        }
        $this->configureMailerSpool($name, $mailer, $container, $transportId, $isDefaultMailer);
        $this->configureMailerSenderAddress($name, $mailer, $container, $isDefaultMailer);
        $this->configureMailerAntiFlood($name, $mailer, $container, $isDefaultMailer);
        $this->configureMailerDeliveryAddress($name, $mailer, $container, $isDefaultMailer);
        $this->configureMailerLogging($name, $mailer, $container, $isDefaultMailer);

        $container->setParameter(sprintf('swiftmailer.mailer.%s.delivery.enabled', $name), !$disableDelivery);

        // alias
        if ($isDefaultMailer) {
            $container->setAlias('swiftmailer.mailer', sprintf('swiftmailer.mailer.%s', $name));
            $container->setAlias('swiftmailer.transport', new Alias(sprintf('swiftmailer.mailer.%s.transport', $name), true));
            $container->setParameter('swiftmailer.spool.enabled', $container->getParameter(sprintf('swiftmailer.mailer.%s.spool.enabled', $name)));
            $container->setParameter('swiftmailer.delivery.enabled', $container->getParameter(sprintf('swiftmailer.mailer.%s.delivery.enabled', $name)));
            $container->setParameter('swiftmailer.single_address', $container->getParameter(sprintf('swiftmailer.mailer.%s.single_address', $name)));
            $container->setAlias('Swift_Mailer', new Alias('swiftmailer.mailer', false));
            $container->setAlias('Swift_Transport', new Alias('swiftmailer.transport', false));
        }
    }

    protected function configureMailerTransport($name, array $mailer, ContainerBuilder $container, $transport, $isDefaultMailer = false)
    {
        foreach (['encryption', 'port', 'host', 'username', 'password', 'auth_mode', 'timeout', 'source_ip', 'local_domain'] as $key) {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.transport.smtp.%s', $name, $key), $mailer[$key]);
        }

        if ('smtp' === $transport) {
            $authDecorator = $this->createChildDefinition('swiftmailer.transport.authhandler.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.authhandler', $name), $authDecorator)
                ->addMethodCall('setUsername', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.username%%', $name)])
                ->addMethodCall('setPassword', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.password%%', $name)])
                ->addMethodCall('setAuthMode', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.auth_mode%%', $name)]);

            $bufferDecorator = $this->createChildDefinition('swiftmailer.transport.buffer.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.buffer', $name), $bufferDecorator);

            $configuratorDecorator = $this->createChildDefinition('swiftmailer.transport.smtp.configurator.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.transport.configurator.%s', $name), $configuratorDecorator)
                ->setArguments([
                    sprintf('%%swiftmailer.mailer.%s.transport.smtp.local_domain%%', $name),
                    new Reference('router.request_context', ContainerInterface::NULL_ON_INVALID_REFERENCE),
                ])
            ;

            $definitionDecorator = $this->createChildDefinition('swiftmailer.transport.smtp.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.smtp', $name), $definitionDecorator)
                ->setArguments([
                    new Reference(sprintf('swiftmailer.mailer.%s.transport.buffer', $name)),
                    [new Reference(sprintf('swiftmailer.mailer.%s.transport.authhandler', $name))],
                    new Reference(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', $name)),
                ])
                ->addMethodCall('setHost', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.host%%', $name)])
                ->addMethodCall('setPort', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.port%%', $name)])
                ->addMethodCall('setEncryption', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.encryption%%', $name)])
                ->addMethodCall('setTimeout', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.timeout%%', $name)])
                ->addMethodCall('setSourceIp', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.source_ip%%', $name)])
                ->setConfigurator([new Reference(sprintf('swiftmailer.transport.configurator.%s', $name)), 'configure'])
            ;

            if (isset($mailer['stream_options'])) {
                $container->setParameter(sprintf('swiftmailer.mailer.%s.transport.smtp.stream_options', $name), $mailer['stream_options']);
                $definitionDecorator->addMethodCall('setStreamOptions', [sprintf('%%swiftmailer.mailer.%s.transport.smtp.stream_options%%', $name)]);
            }

            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', $name), sprintf('swiftmailer.mailer.%s.transport.%s', $name, $transport));
        } elseif ('sendmail' === $transport) {
            $bufferDecorator = $this->createChildDefinition('swiftmailer.transport.buffer.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.buffer', $name), $bufferDecorator);

            $configuratorDecorator = $this->createChildDefinition('swiftmailer.transport.smtp.configurator.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.transport.configurator.%s', $name), $configuratorDecorator)
                ->setArguments([
                    sprintf('%%swiftmailer.mailer.%s.transport.smtp.local_domain%%', $name),
                    new Reference('router.request_context', ContainerInterface::NULL_ON_INVALID_REFERENCE),
                ])
            ;

            $definitionDecorator = $this->createChildDefinition(sprintf('swiftmailer.transport.%s.abstract', $transport));
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.%s', $name, $transport), $definitionDecorator)
                ->setArguments([
                    new Reference(sprintf('swiftmailer.mailer.%s.transport.buffer', $name)),
                    new Reference(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', $name)),
                ])
                ->addMethodCall('setCommand', [$mailer['command']])
                ->setConfigurator([new Reference(sprintf('swiftmailer.transport.configurator.%s', $name)), 'configure'])
            ;

            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', $name), sprintf('swiftmailer.mailer.%s.transport.%s', $name, $transport));
        } elseif ('null' === $transport) {
            $definitionDecorator = $this->createChildDefinition('swiftmailer.transport.null.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.null', $name), $definitionDecorator)
                ->setArguments([
                    new Reference(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', $name)),
                ])
            ;
            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', $name), sprintf('swiftmailer.mailer.%s.transport.%s', $name, $transport));
        } else {
            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', $name), sprintf('swiftmailer.mailer.transport.%s', $transport));
        }

        if (method_exists(Alias::class, 'setPrivate')) {
            $container->getAlias(sprintf('swiftmailer.mailer.%s.transport', $name))->setPrivate(false);
        }

        $definitionDecorator = $this->createChildDefinition('swiftmailer.mailer.abstract');
        $container
            ->setDefinition(sprintf('swiftmailer.mailer.%s', $name), $definitionDecorator)
            ->replaceArgument(0, new Reference(sprintf('swiftmailer.mailer.%s.transport', $name)))
        ;
    }

    protected function configureMailerSpool($name, array $mailer, ContainerBuilder $container, $transport, $isDefaultMailer = false)
    {
        if (isset($mailer['spool'])) {
            $type = $mailer['spool']['type'];
            if ('service' === $type) {
                $container->setAlias(sprintf('swiftmailer.mailer.%s.spool.service', $name), $mailer['spool']['id']);
            } else {
                foreach (['path'] as $key) {
                    $container->setParameter(sprintf('swiftmailer.spool.%s.%s.%s', $name, $type, $key), $mailer['spool'][$key].'/'.$name);
                }
            }

            $definitionDecorator = $this->createChildDefinition(sprintf('swiftmailer.spool.%s.abstract', $type));
            if ('file' === $type) {
                $container
                    ->setDefinition(sprintf('swiftmailer.mailer.%s.spool.file', $name), $definitionDecorator)
                    ->replaceArgument(0, sprintf('%%swiftmailer.spool.%s.file.path%%', $name))
                ;
            } elseif ('memory' === $type) {
                $container
                    ->setDefinition(sprintf('swiftmailer.mailer.%s.spool.memory', $name), $definitionDecorator)
                ;
            }
            $container->setAlias(sprintf('swiftmailer.mailer.%s.spool', $name), sprintf('swiftmailer.mailer.%s.spool.%s', $name, $type));

            $definitionDecorator = $this->createChildDefinition('swiftmailer.transport.spool.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.transport.spool', $name), $definitionDecorator)
                ->setArguments([
                    new Reference(sprintf('swiftmailer.mailer.%s.transport.eventdispatcher', $name)),
                    new Reference(sprintf('swiftmailer.mailer.%s.spool', $name)),
                ])
            ;

            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport.real', $name), $transport);
            $container->getAlias(sprintf('swiftmailer.mailer.%s.transport.real', $name))->setPublic(true);
            $container->setAlias(sprintf('swiftmailer.mailer.%s.transport', $name), sprintf('swiftmailer.mailer.%s.transport.spool', $name));
            $container->setParameter(sprintf('swiftmailer.mailer.%s.spool.enabled', $name), true);
            if (true === $isDefaultMailer) {
                $container->setAlias('swiftmailer.spool', sprintf('swiftmailer.mailer.%s.spool', $name));
                $container->setAlias('swiftmailer.transport.real', sprintf('swiftmailer.mailer.%s.transport.real', $name));
                $container->setAlias('Swift_Spool', new Alias('swiftmailer.spool', false));
            }
        } else {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.spool.enabled', $name), false);
        }
    }

    protected function configureMailerSenderAddress($name, array $mailer, ContainerBuilder $container, $isDefaultMailer = false)
    {
        if (isset($mailer['sender_address']) && $mailer['sender_address']) {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.sender_address', $name), $mailer['sender_address']);
            $definitionDecorator = $this->createChildDefinition('swiftmailer.plugin.impersonate.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.plugin.impersonate', $name), $definitionDecorator)
                ->setArguments([
                    sprintf('%%swiftmailer.mailer.%s.sender_address%%', $name),
                ])
            ;
            $container->getDefinition(sprintf('swiftmailer.mailer.%s.plugin.impersonate', $name))->addTag(sprintf('swiftmailer.%s.plugin', $name));
            if (true === $isDefaultMailer) {
                $container->setAlias('swiftmailer.plugin.impersonate', sprintf('swiftmailer.mailer.%s.plugin.impersonate', $name));
                $container->setParameter('swiftmailer.sender_address', $container->getParameter(sprintf('swiftmailer.mailer.%s.sender_address', $name)));
            }
        } else {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.plugin.impersonate', $name), null);
        }
    }

    protected function configureMailerAntiFlood($name, array $mailer, ContainerBuilder $container, $isDefaultMailer = false)
    {
        if (isset($mailer['antiflood'])) {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.antiflood.threshold', $name), $mailer['antiflood']['threshold']);
            $container->setParameter(sprintf('swiftmailer.mailer.%s.antiflood.sleep', $name), $mailer['antiflood']['sleep']);
            $definitionDecorator = $this->createChildDefinition('swiftmailer.plugin.antiflood.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.plugin.antiflood', $name), $definitionDecorator)
                ->setArguments([
                    sprintf('%%swiftmailer.mailer.%s.antiflood.threshold%%', $name),
                    sprintf('%%swiftmailer.mailer.%s.antiflood.sleep%%', $name),
                ])
            ;
            $container->getDefinition(sprintf('swiftmailer.mailer.%s.plugin.antiflood', $name))->addTag(sprintf('swiftmailer.%s.plugin', $name));
            if (true === $isDefaultMailer) {
                $container->setAlias('swiftmailer.mailer.plugin.antiflood', sprintf('swiftmailer.mailer.%s.plugin.antiflood', $name));
            }
        }
    }

    protected function configureMailerDeliveryAddress($name, array $mailer, ContainerBuilder $container, $isDefaultMailer = false)
    {
        if (\count($mailer['delivery_addresses']) > 0) {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.single_address', $name), $mailer['delivery_addresses'][0]);
            $container->setParameter(sprintf('swiftmailer.mailer.%s.delivery_addresses', $name), $mailer['delivery_addresses']);
            $container->setParameter(sprintf('swiftmailer.mailer.%s.delivery_whitelist', $name), $mailer['delivery_whitelist']);
            $definitionDecorator = $this->createChildDefinition('swiftmailer.plugin.redirecting.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.plugin.redirecting', $name), $definitionDecorator)
                ->setArguments([
                    sprintf('%%swiftmailer.mailer.%s.delivery_addresses%%', $name),
                    sprintf('%%swiftmailer.mailer.%s.delivery_whitelist%%', $name),
                ])
            ;
            $container->getDefinition(sprintf('swiftmailer.mailer.%s.plugin.redirecting', $name))->addTag(sprintf('swiftmailer.%s.plugin', $name));
            if (true === $isDefaultMailer) {
                $container->setAlias('swiftmailer.plugin.redirecting', sprintf('swiftmailer.mailer.%s.plugin.redirecting', $name));
            }
        } else {
            $container->setParameter(sprintf('swiftmailer.mailer.%s.single_address', $name), null);
        }
    }

    protected function configureMailerLogging($name, array $mailer, ContainerBuilder $container, $isDefaultMailer = false)
    {
        if ($mailer['logging']) {
            $container->getDefinition('swiftmailer.plugin.messagelogger.abstract');
            $definitionDecorator = $this->createChildDefinition('swiftmailer.plugin.messagelogger.abstract');
            $container
                ->setDefinition(sprintf('swiftmailer.mailer.%s.plugin.messagelogger', $name), $definitionDecorator)
            ;
            $container->getDefinition(sprintf('swiftmailer.mailer.%s.plugin.messagelogger', $name))
                ->setPublic(true)
                ->addTag(sprintf('swiftmailer.%s.plugin', $name));
            if (true === $isDefaultMailer) {
                $container->setAlias('swiftmailer.plugin.messagelogger', sprintf('swiftmailer.mailer.%s.plugin.messagelogger', $name));
            }
        }
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     */
    public function getXsdValidationBasePath()
    {
        return __DIR__.'/../Resources/config/schema';
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     */
    public function getNamespace()
    {
        return 'http://symfony.com/schema/dic/swiftmailer';
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($container->getParameter('kernel.debug'));
    }

    private function createChildDefinition($id)
    {
        if (class_exists('Symfony\Component\DependencyInjection\ChildDefinition')) {
            return new ChildDefinition($id);
        }

        return new DefinitionDecorator($id);
    }
}
