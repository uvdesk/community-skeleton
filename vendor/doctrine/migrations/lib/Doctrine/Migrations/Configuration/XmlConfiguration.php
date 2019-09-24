<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Configuration;

use Doctrine\Migrations\Configuration\Exception\XmlNotValid;
use Doctrine\Migrations\Tools\BooleanStringFormatter;
use DOMDocument;
use SimpleXMLElement;
use const DIRECTORY_SEPARATOR;
use const LIBXML_NOCDATA;
use function assert;
use function file_get_contents;
use function libxml_clear_errors;
use function libxml_use_internal_errors;
use function simplexml_load_string;

/**
 * The XmlConfiguration class is responsible for loading migration configuration information from a XML file.
 *
 * @internal
 */
class XmlConfiguration extends AbstractFileConfiguration
{
    /** @inheritdoc */
    protected function doLoad(string $file) : void
    {
        libxml_use_internal_errors(true);

        $xml = new DOMDocument();

        if ($xml->load($file) === false) {
            throw XmlNotValid::malformed();
        }

        $xsdPath = __DIR__ . DIRECTORY_SEPARATOR . 'XML' . DIRECTORY_SEPARATOR . 'configuration.xsd';

        if (! $xml->schemaValidate($xsdPath)) {
            libxml_clear_errors();

            throw XmlNotValid::failedValidation();
        }

        $rawXML = file_get_contents($file);
        assert($rawXML !== false);

        $xml = simplexml_load_string($rawXML, SimpleXMLElement::class, LIBXML_NOCDATA);
        assert($xml !== false);

        $config = [];

        if (isset($xml->name)) {
            $config['name'] = (string) $xml->name;
        }

        if (isset($xml->{'custom-template'})) {
            $config['custom_template'] = (string) $xml->{'custom-template'};
        }

        if (isset($xml->table['name'])) {
            $config['table_name'] = (string) $xml->table['name'];
        }

        if (isset($xml->table['column'])) {
            $config['column_name'] = (string) $xml->table['column'];
        }

        if (isset($xml->table['column_length'])) {
            $config['column_length'] = (int) $xml->table['column_length'];
        }

        if (isset($xml->table['executed_at_column'])) {
            $config['executed_at_column_name'] = (string) $xml->table['executed_at_column'];
        }

        if (isset($xml->{'migrations-namespace'})) {
            $config['migrations_namespace'] = (string) $xml->{'migrations-namespace'};
        }

        if (isset($xml->{'organize-migrations'})) {
            $config['organize_migrations'] = (string) $xml->{'organize-migrations'};
        }

        if (isset($xml->{'migrations-directory'})) {
            $config['migrations_directory'] = $this->getDirectoryRelativeToFile(
                $file,
                (string) $xml->{'migrations-directory'}
            );
        }

        if (isset($xml->{'all-or-nothing'})) {
            $config['all_or_nothing'] = BooleanStringFormatter::toBoolean(
                (string) $xml->{'all-or-nothing'},
                false
            );
        }

        if (isset($xml->migrations->migration)) {
            $migrations = [];

            foreach ($xml->migrations->migration as $migration) {
                $attributes = $migration->attributes();

                $version = (string) $attributes['version'];
                $class   = (string) $attributes['class'];

                $migrations[] = [
                    'version' => $version,
                    'class' => $class,
                ];
            }

            $config['migrations'] = $migrations;
        }

        $this->setConfiguration($config);
    }
}
