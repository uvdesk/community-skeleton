<?php

namespace Doctrine\DBAL\Platforms;

use function explode;

/**
 * Provides the behavior, features and SQL dialect of the PostgreSQL 9.1 database platform.
 */
class PostgreSQL91Platform extends PostgreSqlPlatform
{
    /**
     * {@inheritDoc}
     */
    public function supportsColumnCollation()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\PostgreSQL91Keywords::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getColumnCollationDeclarationSQL($collation)
    {
        return 'COLLATE ' . $this->quoteSingleIdentifier($collation);
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableColumnsSQL($table, $database = null)
    {
        $sql   = parent::getListTableColumnsSQL($table, $database);
        $parts = explode('AS complete_type,', $sql, 2);

        return $parts[0] . 'AS complete_type, (SELECT tc.collcollate FROM pg_catalog.pg_collation tc WHERE tc.oid = a.attcollation) AS collation,' . $parts[1];
    }
}
