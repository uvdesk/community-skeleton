<?php

namespace Doctrine\DBAL\Driver;

use IteratorAggregate;

class StatementIterator implements IteratorAggregate
{
    /** @var Statement */
    private $statement;

    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        while (($result = $this->statement->fetch()) !== false) {
            yield $result;
        }
    }
}
