<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\Migrations\Exception\NoTablesFound;
use Doctrine\Migrations\Generator\Generator;
use Doctrine\Migrations\Generator\SqlGenerator;
use function count;
use function implode;

/**
 * The SchemaDumper class is responsible for dumping the current state of your database schema to a migration. This
 * is to be used in conjunction with the Rollup class.
 *
 * @internal
 *
 * @see Doctrine\Migrations\Rollup
 */
class SchemaDumper
{
    /** @var AbstractPlatform */
    private $platform;

    /** @var AbstractSchemaManager */
    private $schemaManager;

    /** @var Generator */
    private $migrationGenerator;

    /** @var SqlGenerator */
    private $migrationSqlGenerator;

    public function __construct(
        AbstractPlatform $platform,
        AbstractSchemaManager $schemaManager,
        Generator $migrationGenerator,
        SqlGenerator $migrationSqlGenerator
    ) {
        $this->platform              = $platform;
        $this->schemaManager         = $schemaManager;
        $this->migrationGenerator    = $migrationGenerator;
        $this->migrationSqlGenerator = $migrationSqlGenerator;
    }

    /**
     * @throws NoTablesFound
     */
    public function dump(
        string $versionNumber,
        bool $formatted = false,
        int $lineLength = 120
    ) : string {
        $schema = $this->schemaManager->createSchema();

        $up   = [];
        $down = [];

        foreach ($schema->getTables() as $table) {
            $upSql = $this->platform->getCreateTableSQL($table);

            $upCode = $this->migrationSqlGenerator->generate(
                $upSql,
                $formatted,
                $lineLength
            );

            if ($upCode !== '') {
                $up[] = $upCode;
            }

            $downSql = [$this->platform->getDropTableSQL($table)];

            $downCode = $this->migrationSqlGenerator->generate(
                $downSql,
                $formatted,
                $lineLength
            );

            if ($downCode === '') {
                continue;
            }

            $down[] = $downCode;
        }

        if (count($up) === 0) {
            throw NoTablesFound::new();
        }

        $up   = implode("\n", $up);
        $down = implode("\n", $down);

        return $this->migrationGenerator->generateMigration(
            $versionNumber,
            $up,
            $down
        );
    }
}
