<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Security;

use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;

/**
 * @internal
 */
final class SecurityConfigUpdater
{
    /** @var YamlSourceManipulator */
    private $manipulator;

    /**
     * Updates security.yaml contents based on a new User class.
     *
     * @param string                 $yamlSource
     * @param UserClassConfiguration $userConfig
     * @param string                 $userClass
     *
     * @return string
     */
    public function updateForUserClass(string $yamlSource, UserClassConfiguration $userConfig, string $userClass): string
    {
        $this->manipulator = new YamlSourceManipulator($yamlSource);

        $this->normalizeSecurityYamlFile();

        $this->updateProviders($userConfig, $userClass);

        if ($userConfig->hasPassword()) {
            $this->updateEncoders($userConfig, $userClass);
        }

        $contents = $this->manipulator->getContents();
        $this->manipulator = null;

        return $contents;
    }

    public function updateForAuthenticator(string $yamlSource, string $firewallName, $chosenEntryPoint, string $authenticatorClass, bool $logoutSetup): string
    {
        $this->manipulator = new YamlSourceManipulator($yamlSource);

        $this->normalizeSecurityYamlFile();

        $newData = $this->manipulator->getData();

        if (!isset($newData['security']['firewalls'])) {
            $newData['security']['firewalls'] = [];
        }

        if (!isset($newData['security']['firewalls'][$firewallName])) {
            $newData['security']['firewalls'][$firewallName] = ['anonymous' => true];
        }

        $firewall = $newData['security']['firewalls'][$firewallName];

        if (!isset($firewall['guard'])) {
            $firewall['guard'] = [];
        }

        if (!isset($firewall['guard']['authenticators'])) {
            $firewall['guard']['authenticators'] = [];
        }

        $firewall['guard']['authenticators'][] = $authenticatorClass;

        if (\count($firewall['guard']['authenticators']) > 1) {
            $firewall['guard']['entry_point'] = $chosenEntryPoint ?? current($firewall['guard']['authenticators']);
        }

        if (!isset($firewall['logout']) && $logoutSetup) {
            $firewall['logout'] = ['path' => 'app_logout'];
            $firewall['logout'][] = $this->manipulator->createCommentLine(
                ' where to redirect after logout'
            );
            $firewall['logout'][] = $this->manipulator->createCommentLine(
                ' target: app_any_route'
            );
        }

        $newData['security']['firewalls'][$firewallName] = $firewall;
        $this->manipulator->setData($newData);
        $contents = $this->manipulator->getContents();

        return $contents;
    }

    private function normalizeSecurityYamlFile()
    {
        if (!isset($this->manipulator->getData()['security'])) {
            $newData = $this->manipulator->getData();
            $newData['security'] = [];
            $this->manipulator->setData($newData);
        }
    }

    private function updateProviders(UserClassConfiguration $userConfig, string $userClass)
    {
        if ($this->isSingleInMemoryProviderConfigured()) {
            // empty the providers if the generic "in_memory" is the only one
            $newData = $this->manipulator->getData();
            $newData['security']['providers'] = [];
            $this->manipulator->setData($newData);
        }

        $newData = $this->manipulator->getData();
        $newData['security']['providers']['__'] = $this->manipulator->createCommentLine(
            ' used to reload user from session & other features (e.g. switch_user)'
        );
        if ($userConfig->isEntity()) {
            $newData['security']['providers']['app_user_provider'] = [
                'entity' => [
                    'class' => $userClass,
                    'property' => $userConfig->getIdentityPropertyName(),
                ],
            ];
        } else {
            if (!$userConfig->getUserProviderClass()) {
                throw new \LogicException('User provider class must be set for non-entity user.');
            }

            $newData['security']['providers']['app_user_provider'] = [
                'id' => $userConfig->getUserProviderClass(),
            ];
        }
        $this->manipulator->setData($newData);
    }

    private function updateEncoders(UserClassConfiguration $userConfig, string $userClass)
    {
        $newData = $this->manipulator->getData();
        if (!isset($newData['security']['encoders'])) {
            // encoders is usually the first key, by convention
            $newData['security'] = ['encoders' => []] + $newData['security'];
        }

        $newData['security']['encoders'][$userClass] = [
            'algorithm' => $userConfig->shouldUseArgon2() ? 'argon2i' : (class_exists(NativePasswordEncoder::class) ? 'auto' : 'bcrypt'),
        ];
        $newData['security']['encoders']['_'] = $this->manipulator->createEmptyLine();

        $this->manipulator->setData($newData);
    }

    private function isSingleInMemoryProviderConfigured(): bool
    {
        if (!isset($this->manipulator->getData()['security']['providers'])) {
            return false;
        }

        $providersConfig = $this->manipulator->getData()['security']['providers'];

        if (1 !== \count($providersConfig)) {
            return false;
        }

        $firstProviderConfig = array_values($providersConfig)[0];

        return \array_key_exists('memory', $firstProviderConfig);
    }
}
