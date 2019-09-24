<?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Sequence;

/**
 * The SQLAnywhere12Platform provides the behavior, features and SQL dialect of the
 * SAP Sybase SQL Anywhere 12 database platform.
 */
class SQLAnywhere12Platform extends SQLAnywhere11Platform
{
    /**
     * {@inheritdoc}
     */
    public function getCreateSequenceSQL(Sequence $sequence)
    {
        return 'CREATE SEQUENCE ' . $sequence->getQuotedName($this) .
            ' INCREMENT BY ' . $sequence->getAllocationSize() .
            ' START WITH ' . $sequence->getInitialValue() .
            ' MINVALUE ' . $sequence->getInitialValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getAlterSequenceSQL(Sequence $sequence)
    {
        return 'ALTER SEQUENCE ' . $sequence->getQuotedName($this) .
            ' INCREMENT BY ' . $sequence->getAllocationSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTzFormatString()
    {
        return 'Y-m-d H:i:s.uP';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTzTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIMESTAMP WITH TIME ZONE';
    }

    /**
     * {@inheritdoc}
     */
    public function getDropSequenceSQL($sequence)
    {
        if ($sequence instanceof Sequence) {
            $sequence = $sequence->getQuotedName($this);
        }

        return 'DROP SEQUENCE ' . $sequence;
    }

    /**
     * {@inheritdoc}
     */
    public function getListSequencesSQL($database)
    {
        return 'SELECT sequence_name, increment_by, start_with, min_value FROM SYS.SYSSEQUENCE';
    }

    /**
     * {@inheritdoc}
     */
    public function getSequenceNextValSQL($sequenceName)
    {
        return 'SELECT ' . $sequenceName . '.NEXTVAL';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsSequences()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAdvancedIndexOptionsSQL(Index $index)
    {
        if (! $index->isPrimary() && $index->isUnique() && $index->hasFlag('with_nulls_not_distinct')) {
            return ' WITH NULLS NOT DISTINCT' . parent::getAdvancedIndexOptionsSQL($index);
        }

        return parent::getAdvancedIndexOptionsSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLAnywhere12Keywords::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        parent::initializeDoctrineTypeMappings();
        $this->doctrineTypeMapping['timestamp with time zone'] = 'datetime';
    }
}
