<?php

namespace Doctrine\DBAL\Platforms\Keywords;

use function array_merge;

/**
 * SAP Sybase SQL Anywhere 16 reserved keywords list.
 */
class SQLAnywhere16Keywords extends SQLAnywhere12Keywords
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SQLAnywhere16';
    }

    /**
     * {@inheritdoc}
     *
     * @link http://dcx.sybase.com/index.html#sa160/en/dbreference/alhakeywords.html
     */
    protected function getKeywords()
    {
        return array_merge(
            parent::getKeywords(),
            [
                'ARRAY',
                'JSON',
                'ROW',
                'ROWTYPE',
                'UNNEST',
                'VARRAY',
            ]
        );
    }
}
