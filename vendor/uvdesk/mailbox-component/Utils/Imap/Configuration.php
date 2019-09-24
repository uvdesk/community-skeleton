<?php

namespace Webkul\UVDesk\MailboxBundle\Utils\Imap;

final class Configuration
{
    private static $reflectedDefinitions = [];

    private function __construct()
    {
        // Force prevent instantiation
    }

    private static function getAvailableDefinitions(bool $ignoreCache = false) : array
    {
        if (empty(self::$reflectedDefinitions) || true === $ignoreCache) {
            if (true === $ignoreCache) {
                // Since we are ignoring the cached results we'll reset this to an empty collection.
                self::$reflectedDefinitions = [];
            }

            // Scan all php files within the target namespace directory
            $scannedFiles = array_filter(scandir(__DIR__ . "/Transport"), function($path) {
                return ('.' != $path && '..' != $path) ? (bool) ('php' === substr($path, strpos($path, '.') + 1)) : false;
            });
    
            // Filter invalid\unsupported classes
            foreach ($scannedFiles as $fileName) {
                $classPath = sprintf("%s\Transport\%s", __NAMESPACE__, substr($fileName, 0, strpos($fileName, '.')));
    
                try {
                    $reflectionClass = new \ReflectionClass($classPath);
    
                    if ($reflectionClass->isInstantiable() && ($reflectionClass->implementsInterface(ResolvedConfigurationInterface::class) || $reflectionClass->implementsInterface(CustomConfigurationInterface::class))) {
                        self::$reflectedDefinitions[] = $reflectionClass;
                    }
                } catch (\ReflectionException $exception) {
                    continue;
                } catch (\RuntimeException $exception) {
                    continue;
                }
            }
        }

        return self::$reflectedDefinitions;
    }

    public static function getSupportedTransportTypes() : array
    {
        return array_map(function ($imapDefinition) {
            return $imapDefinition->getName()::getCode();
        }, self::getAvailableDefinitions());
    }

    public static function guessTransportDefinition($host) : ConfigurationInterface
    {
        foreach (self::getAvailableDefinitions() as $reflectedImapDefinition) {
            if (true === $reflectedImapDefinition->implementsInterface(CustomConfigurationInterface::class)) {
                $customConfigurationReflection = $reflectedImapDefinition;
                continue;
            }

            if ($reflectedImapDefinition->getName()::getHost() == $host) {
                return $reflectedImapDefinition->newInstance();
            }
        }

        if (!empty($customConfigurationReflection)) {
            return $customConfigurationReflection->newInstance($host);
        }

        throw new \Exception('No matching imap definition found for host address "' . $host . '".');
    }

    public static function createTransportDefinition($transportCode, $host = null) : ConfigurationInterface
    {
        if (false == in_array($transportCode, self::getSupportedTransportTypes(), true)) {
            throw new \Exception('No imap definition found for transport type "' . $transportCode . '".');
        }

        foreach (self::getAvailableDefinitions() as $reflectedImapDefinition) {
            if ($reflectedImapDefinition->getName()::getCode() !== $transportCode) {
                continue;
            }

            if (true === $reflectedImapDefinition->implementsInterface(CustomConfigurationInterface::class)) {
                return $reflectedImapDefinition->newInstance($host);
            }

            return $reflectedImapDefinition->newInstance();
        }
    }
}
