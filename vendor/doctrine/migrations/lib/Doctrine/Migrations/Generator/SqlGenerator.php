<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Generator;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\Migrations\Configuration\Configuration;
use SqlFormatter;
use function array_unshift;
use function count;
use function implode;
use function sprintf;
use function stripos;
use function strlen;
use function var_export;

/**
 * The SqlGenerator class is responsible for generating the body of the up() and down() methods for a migration
 * from an array of SQL queries.
 *
 * @internal
 */
class SqlGenerator
{
    /** @var Configuration */
    private $configuration;

    /** @var AbstractPlatform */
    private $platform;

    public function __construct(Configuration $configuration, AbstractPlatform $platform)
    {
        $this->configuration = $configuration;
        $this->platform      = $platform;
    }

    /** @param string[] $sql */
    public function generate(
        array $sql,
        bool $formatted = false,
        int $lineLength = 120,
        bool $checkDbPlatform = true
    ) : string {
        $code = [];

        foreach ($sql as $query) {
            if (stripos($query, $this->configuration->getMigrationsTableName()) !== false) {
                continue;
            }

            if ($formatted) {
                $maxLength = $lineLength - 18 - 8; // max - php code length - indentation

                if (strlen($query) > $maxLength) {
                    $query = SqlFormatter::format($query, false);
                }
            }

            $code[] = sprintf('$this->addSql(%s);', var_export($query, true));
        }

        if (count($code) !== 0 && $checkDbPlatform && $this->configuration->isDatabasePlatformChecked()) {
            $currentPlatform = $this->platform->getName();

            array_unshift(
                $code,
                sprintf(
                    '$this->abortIf($this->connection->getDatabasePlatform()->getName() !== %s, %s);',
                    var_export($currentPlatform, true),
                    var_export(sprintf("Migration can only be executed safely on '%s'.", $currentPlatform), true)
                ),
                ''
            );
        }

        return implode("\n", $code);
    }
}
