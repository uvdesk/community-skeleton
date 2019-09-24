<?php

namespace Doctrine\DBAL\Platforms;

/**
 * Platform to ensure compatibility of Doctrine with Microsoft SQL Server 2008 version.
 *
 * Differences to SQL Server 2005 and before are that a new DATETIME2 type was
 * introduced that has a higher precision.
 */
class SQLServer2008Platform extends SQLServer2005Platform
{
    /**
     * {@inheritDoc}
     */
    public function getListTablesSQL()
    {
        // "sysdiagrams" table must be ignored as it's internal SQL Server table for Database Diagrams
        // Category 2 must be ignored as it is "MS SQL Server 'pseudo-system' object[s]" for replication
        return "SELECT name, SCHEMA_NAME (uid) AS schema_name FROM sysobjects WHERE type = 'U' AND name != 'sysdiagrams' AND category != 2 ORDER BY name";
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        // 3 - microseconds precision length
        // http://msdn.microsoft.com/en-us/library/ms187819.aspx
        return 'DATETIME2(6)';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATE';
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIME(0)';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTzTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATETIMEOFFSET(6)';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeFormatString()
    {
        return 'Y-m-d H:i:s.u';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTzFormatString()
    {
        return 'Y-m-d H:i:s.u P';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateFormatString()
    {
        return 'Y-m-d';
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeFormatString()
    {
        return 'H:i:s';
    }

    /**
     * {@inheritDoc}
     *
     * Adding Datetime2 Type
     */
    protected function initializeDoctrineTypeMappings()
    {
        parent::initializeDoctrineTypeMappings();
        $this->doctrineTypeMapping['datetime2']      = 'datetime';
        $this->doctrineTypeMapping['date']           = 'date';
        $this->doctrineTypeMapping['time']           = 'time';
        $this->doctrineTypeMapping['datetimeoffset'] = 'datetimetz';
    }

    /**
     * {@inheritdoc}
     *
     * Returns Microsoft SQL Server 2008 specific keywords class
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLServer2008Keywords::class;
    }

    protected function getLikeWildcardCharacters() : string
    {
        return parent::getLikeWildcardCharacters() . '[]^';
    }
}
