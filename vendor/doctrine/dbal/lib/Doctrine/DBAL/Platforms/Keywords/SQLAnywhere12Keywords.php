<?php

namespace Doctrine\DBAL\Platforms\Keywords;

use function array_diff;
use function array_merge;

/**
 * SAP Sybase SQL Anywhere 12 reserved keywords list.
 */
class SQLAnywhere12Keywords extends SQLAnywhere11Keywords
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SQLAnywhere12';
    }

    /**
     * {@inheritdoc}
     *
     * @link http://dcx.sybase.com/1200/en/dbreference/alhakeywords.html
     */
    protected function getKeywords()
    {
        return array_merge(
            array_diff(
                parent::getKeywords(),
                [
                    'INDEX_LPAREN',
                    'SYNTAX_ERROR',
                    'WITH_CUBE',
                    'WITH_LPAREN',
                    'WITH_ROLLUP',
                ]
            ),
            [
                'DATETIMEOFFSET',
                'LIMIT',
                'OPENXML',
                'SPATIAL',
                'TREAT',
            ]
        );
    }
}
