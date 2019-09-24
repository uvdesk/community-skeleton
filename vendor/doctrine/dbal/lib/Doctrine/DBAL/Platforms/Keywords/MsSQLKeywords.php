<?php

namespace Doctrine\DBAL\Platforms\Keywords;

/**
 * MsSQL Keywordlist
 *
 * @deprecated Use SQLServerKeywords class instead.
 *
 * @link       www.doctrine-project.com
 */
class MsSQLKeywords extends SQLServerKeywords
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'MsSQL';
    }
}
