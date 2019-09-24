<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration;

use Doctrine\Migrations\Configuration\Exception\JsonNotValid;
use const JSON_ERROR_NONE;
use function assert;
use function file_get_contents;
use function json_decode;
use function json_last_error;

/**
 * The YamlConfiguration class is responsible for loading migration configuration information from a JSON file.
 *
 * @internal
 */
class JsonConfiguration extends AbstractFileConfiguration
{
    /** @inheritdoc */
    protected function doLoad(string $file) : void
    {
        $contents = file_get_contents($file);

        assert($contents !== false);

        $config = json_decode($contents, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonNotValid::new();
        }

        if (isset($config['migrations_directory'])) {
            $config['migrations_directory'] = $this->getDirectoryRelativeToFile(
                $file,
                $config['migrations_directory']
            );
        }

        $this->setConfiguration($config);
    }
}
