<?php

namespace Knp\Component\Pager\Event\Subscriber\Sortable\Doctrine\ORM\Query;

use Doctrine\ORM\Query\TreeWalkerAdapter,
    Doctrine\ORM\Query\AST\SelectStatement,
    Doctrine\ORM\Query\AST\PathExpression,
    Doctrine\ORM\Query\AST\OrderByItem,
    Doctrine\ORM\Query\AST\OrderByClause;

/**
 * OrderBy Query TreeWalker for Sortable functionality
 * in doctrine paginator
 */
class OrderByWalker extends TreeWalkerAdapter
{
    /**
     * Sort key alias hint name
     */
    const HINT_PAGINATOR_SORT_ALIAS = 'knp_paginator.sort.alias';

    /**
     * Sort key field hint name
     */
    const HINT_PAGINATOR_SORT_FIELD = 'knp_paginator.sort.field';

    /**
     * Sort direction hint name
     */
    const HINT_PAGINATOR_SORT_DIRECTION = 'knp_paginator.sort.direction';

    /**
     * Walks down a SelectStatement AST node, modifying it to
     * sort the query like requested by url
     *
     * @param SelectStatement $AST
     * @return void
     */
    public function walkSelectStatement(SelectStatement $AST): void
    {
        $query = $this->_getQuery();
        $fields = (array)$query->getHint(self::HINT_PAGINATOR_SORT_FIELD);
        $aliases = (array)$query->getHint(self::HINT_PAGINATOR_SORT_ALIAS);

        $components = $this->_getQueryComponents();
        foreach ($fields as $index => $field) {
            if (!$field) {
                continue;
            }

            $alias = $aliases[$index];
            if ($alias !== false) {
                if (!array_key_exists($alias, $components)) {
                    throw new \UnexpectedValueException("There is no component aliased by [{$alias}] in the given Query");
                }
                $meta = $components[$alias];
                if (!$meta['metadata']->hasField($field)) {
                    throw new \UnexpectedValueException("There is no such field [{$field}] in the given Query component, aliased by [$alias]");
                }
            } else {
                if (!array_key_exists($field, $components)) {
                    throw new \UnexpectedValueException("There is no component field [{$field}] in the given Query");
                }
            }

            $direction = $query->getHint(self::HINT_PAGINATOR_SORT_DIRECTION);
            if ($alias !== false) {
                $pathExpression = new PathExpression(PathExpression::TYPE_STATE_FIELD, $alias, $field);
                $pathExpression->type = PathExpression::TYPE_STATE_FIELD;
            } else {
                $pathExpression = $field;
            }

            $orderByItem = new OrderByItem($pathExpression);
            $orderByItem->type = $direction;

            if ($AST->orderByClause) {
                $set = false;
                foreach ($AST->orderByClause->orderByItems as $item) {
                    if ($item->expression instanceof PathExpression) {
                        if ($item->expression->identificationVariable === $alias && $item->expression->field === $field) {
                            $item->type = $direction;
                            $set = true;
                            break;
                        }
                    }
                }
                if (!$set) {
                    array_unshift($AST->orderByClause->orderByItems, $orderByItem);
                }
            } else {
                $AST->orderByClause = new OrderByClause([$orderByItem]);
            }
        }
    }
}
