<?php

namespace Doctrine\DBAL\Platforms\Keywords;

use function array_diff;
use function array_merge;

/**
 * Microsoft SQL Server 2005 reserved keyword dictionary.
 *
 * @link    www.doctrine-project.com
 */
class SQLServer2005Keywords extends SQLServerKeywords
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SQLServer2005';
    }

    /**
     * {@inheritdoc}
     *
     * @link http://msdn.microsoft.com/en-US/library/ms189822%28v=sql.90%29.aspx
     */
    protected function getKeywords()
    {
        return array_merge(array_diff(parent::getKeywords(), ['DUMMY']), [
            'EXTERNAL',
            'PIVOT',
            'REVERT',
            'SECURITYAUDIT',
            'TABLESAMPLE',
            'UNPIVOT',
        ]);
    }
}
