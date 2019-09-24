<?php declare(strict_types=1);

namespace PhpParser\Node;

use PhpParser\Node;

interface FunctionLike extends Node
{
    /**
     * Whether to return by reference
     *
     * @return bool
     */
    public function returnsByRef() : bool;

    /**
     * List of parameters
     *
     * @return Node\Param[]
     */
    public function getParams() : array;

    /**
     * Get the declared return type or null
     *
     * @return null|Identifier|Node\Name|Node\NullableType
     */
    public function getReturnType();

    /**
     * The function body
     *
     * @return Node\Stmt[]|null
     */
    public function getStmts();
}
