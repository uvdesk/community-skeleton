<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Version;

use Doctrine\DBAL\Schema\Schema;
use RuntimeException;
use Throwable;
use function count;

/**
 * The ExecutionResult class is responsible for storing the result of a migration version after it executes.
 *
 * @internal
 */
class ExecutionResult
{
    /** @var string[] */
    private $sql = [];

    /** @var mixed[] */
    private $params = [];

    /** @var mixed[] */
    private $types = [];

    /** @var float|null */
    private $time;

    /** @var float|null */
    private $memory;

    /** @var bool */
    private $skipped = false;

    /** @var bool */
    private $error = false;

    /** @var Throwable|null */
    private $exception;

    /** @var Schema|null */
    private $toSchema;

    /**
     * @param string[] $sql
     * @param mixed[]  $params
     * @param mixed[]  $types
     */
    public function __construct(array $sql = [], array $params = [], array $types = [])
    {
        $this->sql    = $sql;
        $this->params = $params;
        $this->types  = $types;
    }

    public function hasSql() : bool
    {
        return count($this->sql) !== 0;
    }

    /**
     * @return string[]
     */
    public function getSql() : array
    {
        return $this->sql;
    }

    /**
     * @param string[] $sql
     */
    public function setSql(array $sql) : void
    {
        $this->sql = $sql;
    }

    /**
     * @return mixed[]
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * @param mixed[] $params
     */
    public function setParams(array $params) : void
    {
        $this->params = $params;
    }

    /**
     * @return mixed[]
     */
    public function getTypes() : array
    {
        return $this->types;
    }

    /**
     * @param mixed[] $types
     */
    public function setTypes(array $types) : void
    {
        $this->types = $types;
    }

    public function getTime() : ?float
    {
        return $this->time;
    }

    public function setTime(float $time) : void
    {
        $this->time = $time;
    }

    public function getMemory() : ?float
    {
        return $this->memory;
    }

    public function setMemory(float $memory) : void
    {
        $this->memory = $memory;
    }

    public function setSkipped(bool $skipped) : void
    {
        $this->skipped = $skipped;
    }

    public function isSkipped() : bool
    {
        return $this->skipped;
    }

    public function setError(bool $error) : void
    {
        $this->error = $error;
    }

    public function hasError() : bool
    {
        return $this->error;
    }

    public function setException(Throwable $exception) : void
    {
        $this->exception = $exception;
    }

    public function getException() : ?Throwable
    {
        return $this->exception;
    }

    public function setToSchema(Schema $toSchema) : void
    {
        $this->toSchema = $toSchema;
    }

    public function getToSchema() : Schema
    {
        if ($this->toSchema === null) {
            throw new RuntimeException('Cannot call getToSchema() when toSchema is null.');
        }

        return $this->toSchema;
    }
}
