<?php

namespace Doctrine\DBAL\Platforms\Keywords;

use function array_diff;
use function array_merge;

/**
 * PostgreSQL 9.4 reserved keywords list.
 */
class PostgreSQL94Keywords extends PostgreSQL92Keywords
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'PostgreSQL94';
    }

    /**
     * {@inheritdoc}
     *
     * @link http://www.postgresql.org/docs/9.4/static/sql-keywords-appendix.html
     */
    protected function getKeywords()
    {
        $parentKeywords = array_diff(parent::getKeywords(), ['OVER']);

        return array_merge($parentKeywords, ['LATERAL']);
    }
}
