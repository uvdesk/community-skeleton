<?php

namespace Knp\Component\Pager;

use Knp\Component\Pager\Pagination\PaginationInterface;


/**
 * PaginatorInterface
 */
interface PaginatorInterface
{
    public const DEFAULT_SORT_FIELD_NAME = 'defaultSortFieldName';
    public const DEFAULT_SORT_DIRECTION = 'defaultSortDirection';
    public const DEFAULT_FILTER_FIELDS = 'defaultFilterFields';
    public const SORT_FIELD_PARAMETER_NAME = 'sortFieldParameterName';
    public const SORT_FIELD_WHITELIST = 'sortFieldWhitelist';
    public const SORT_DIRECTION_PARAMETER_NAME = 'sortDirectionParameterName';
    public const PAGE_PARAMETER_NAME = 'pageParameterName';
    public const FILTER_FIELD_PARAMETER_NAME = 'filterFieldParameterName';
    public const FILTER_VALUE_PARAMETER_NAME = 'filterValueParameterName';
    public const FILTER_FIELD_WHITELIST = 'filterFieldWhitelist';
    public const DISTINCT = 'distinct';

    /**
     * Paginates anything (depending on event listeners)
     * into Pagination object, which is a view targeted
     * pagination object (might be aggregated helper object)
     * responsible for the pagination result representation
     *
     * @param mixed $target - anything what needs to be paginated
     * @param int $page - page number, starting from 1
     * @param int $limit - number of items per page
     * @param array $options - less used options:
     *     boolean $distinct - default true for distinction of results
     *     string $alias - pagination alias, default none
     *     array $whitelist - sortable whitelist for target fields being paginated
     * @throws \LogicException
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function paginate($target, int $page = 1, int $limit = 10, array $options = []): PaginationInterface;
}
