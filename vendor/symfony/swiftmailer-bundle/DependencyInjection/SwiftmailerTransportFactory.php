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

use Symfony\Component\Routing\RequestContext;

/**
 * Factory to create a \Swift_Transport object.
 *
 * @author Romain Gautier <mail@romain.sh>
 */
class SwiftmailerTransportFactory
{
    /**
     * @param array                         $options
     * @param RequestContext|null           $requestContext
     * @param \Swift_Events_EventDispatcher $eventDispatcher
     *
     * @return \Swift_Transport
     *
     * @throws \InvalidArgumentException if the scheme is not a built-in Swiftmailer transport
     */
    public static function createTransport(array $options, RequestContext $requestContext = null, \Swift_Events_EventDispatcher $eventDispatcher)
    {
        $options = static::resolveOptions($options);

        self::validateConfig($options);
        if ('smtp' === $options['transport']) {
            $smtpAuthHandler = new \Swift_Transport_Esmtp_AuthHandler([
                new \Swift_Transport_Esmtp_Auth_CramMd5Authenticator(),
                new \Swift_Transport_Esmtp_Auth_LoginAuthenticator(),
                new \Swift_Transport_Esmtp_Auth_PlainAuthenticator(),
                new \Swift_Transport_Esmtp_Auth_NTLMAuthenticator(),
            ]);
            $smtpAuthHandler->setUsername($options['username']);
            $smtpAuthHandler->setPassword($options['password']);
            $smtpAuthHandler->setAuthMode($options['auth_mode']);

            $transport = new \Swift_Transport_EsmtpTransport(
                new \Swift_Transport_StreamBuffer(new \Swift_StreamFilters_StringReplacementFilterFactory()),
                [$smtpAuthHandler],
                $eventDispatcher
            );
            $transport->setHost($options['host']);
            $transport->setPort($options['port']);
            $transport->setEncryption($options['encryption']);
            $transport->setTimeout($options['timeout']);
            $transport->setSourceIp($options['source_ip']);

            $smtpTransportConfigurator = new SmtpTransportConfigurator($options['local_domain'], $requestContext);
            $smtpTransportConfigurator->configure($transport);
        } elseif ('sendmail' === $options['transport']) {
            $transport = new \Swift_Transport_SendmailTransport(
                new \Swift_Transport_StreamBuffer(new \Swift_StreamFilters_StringReplacementFilterFactory()),
                $eventDispatcher
            );

            $transport->setCommand($options['command']);

            $smtpTransportConfigurator = new SmtpTransportConfigurator($options['local_domain'], $requestContext);
            $smtpTransportConfigurator->configure($transport);
        } elseif ('null' === $options['transport']) {
            $transport = new \Swift_Transport_NullTransport($eventDispatcher);
        } else {
            throw new \InvalidArgumentException(sprintf('Not a built-in Swiftmailer transport: %s.', $options['transport']));
        }

        return $transport;
    }

    /**
     * @param array $options
     *
     * @return array options
     */
    public static function resolveOptions(array $options)
    {
        $options += [
            'transport' => null,
            'username' => null,
            'password' => null,
            'host' => null,
            'port' => null,
            'timeout' => null,
            'source_ip' => null,
            'local_domain' => null,
            'encryption' => null,
            'auth_mode' => null,
            'command' => null,
        ];

        if (isset($options['url'])) {
            if (false === $parts = parse_url($options['url'])) {
                throw new \InvalidArgumentException(sprintf('The Swiftmailer URL "%s" is not valid.', $options['url']));
            }
            if (isset($parts['scheme'])) {
                $options['transport'] = $parts['scheme'];
            }
            if (isset($parts['user'])) {
                $options['username'] = rawurldecode($parts['user']);
            }
            if (isset($parts['pass'])) {
                $options['password'] = rawurldecode($parts['pass']);
            }
            if (isset($parts['host'])) {
                $options['host'] = rawurldecode($parts['host']);
            }
            if (isset($parts['port'])) {
                $options['port'] = $parts['port'];
            }
            if (isset($parts['query'])) {
                parse_str($parts['query'], $query);
                foreach ($options as $key => $value) {
                    if (isset($query[$key]) && '' != $query[$key]) {
                        $options[$key] = $query[$key];
                    }
                }
            }
        }

        if (!isset($options['transport'])) {
            $options['transport'] = 'null';
        } elseif ('gmail' === $options['transport']) {
            $options['encryption'] = 'ssl';
            $options['auth_mode'] = 'login';
            $options['host'] = 'smtp.gmail.com';
            $options['transport'] = 'smtp';
        }

        if (!isset($options['port'])) {
            $options['port'] = 'ssl' === $options['encryption'] ? 465 : 25;
        }

        return $options;
    }

    /**
     * @throws \InvalidArgumentException if the encryption is not valid
     */
    public static function validateConfig($options)
    {
        if (!\in_array($options['encryption'], ['tls', 'ssl', null], true)) {
            throw new \InvalidArgumentException(sprintf('The %s encryption is not supported', $options['encryption']));
        }

        if (!\in_array($options['auth_mode'], ['plain', 'login', 'cram-md5', 'ntlm', null], true)) {
            throw new \InvalidArgumentException(sprintf('The %s authentication mode is not supported', $options['auth_mode']));
        }
    }
}
