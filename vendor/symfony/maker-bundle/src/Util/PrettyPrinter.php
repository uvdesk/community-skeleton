<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Util;

use PhpParser\PrettyPrinter\Standard;
use PhpParser\Node\Stmt;

/**
 * @internal
 */
final class PrettyPrinter extends Standard
{
    /**
     * Overridden to fix indentation problem with tabs.
     *
     * If the original source code uses tabs, then the tokenizer
     * will see this as "1" indent level, and will indent new lines
     * with just 1 space. By changing 1 indent to 4, we effectively
     * "correct" this problem when printing.
     *
     * For code that is even further indented (e.g. 8 spaces),
     * the printer uses the first indentation (here corrected
     * from 1 space to 4) and already (without needing any other
     * changes) adds 4 spaces onto that. This is why we don't
     * also need to handle indent levels of 5, 9, etc: these
     * do not occur (at least in the code we generate);
     *
     * @param int $level
     */
    protected function setIndentLevel(int $level)
    {
        if (1 === $level) {
            $level = 4;
        }

        parent::setIndentLevel($level);
    }

    /**
     * Overridden to change coding standards.
     *
     * Before:
     *      public function getFoo() : string
     *
     * After
     *      public function getFoo(): string
     */
    protected function pStmt_ClassMethod(Stmt\ClassMethod $node)
    {
        $classMethod = parent::pStmt_ClassMethod($node);

        if ($node->returnType) {
            $classMethod = str_replace(') :', '):', $classMethod);
        }

        return $classMethod;
    }
}
