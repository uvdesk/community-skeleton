<?php

namespace Knp\Component\Pager\Pagination;

use Countable, Traversable, ArrayAccess;

/**
 * Pagination interface strictly defines
 * the methods - paginator will use to populate the
 * pagination data
 */
interface PaginationInterface extends Countable, Traversable, ArrayAccess
{
    /**
     * @param int $pageNumber
     */
    public function setCurrentPageNumber(int $pageNumber): void;

    /**
     * Get currently used page number
     *
     * @return int
     */
    public function getCurrentPageNumber(): int;

    /**
     * @param int $numItemsPerPage
     */
    public function setItemNumberPerPage(int $numItemsPerPage): void;

    /**
     * Get number of items per page
     *
     * @return int
     */
    public function getItemNumberPerPage(): int;

    /**
     * @param int $numTotal
     */
    public function setTotalItemCount(int $numTotal): void;

    /**
     * Get total item number available
     *
     * @return int
     */
    public function getTotalItemCount(): int;

    /**
     * @param iterable $items
     */
    public function setItems(iterable $items): void;

    /**
     * Get current items
     *
     * @return iterable
     */
    public function getItems(): iterable;

    /**
     * @param array $options
     */
    public function setPaginatorOptions(array $options): void;

    /**
     * Get pagination alias
     *
     * @return mixed
     */
    public function getPaginatorOption($name);

    /**
     * @param array $parameters
     */
    public function setCustomParameters(array $parameters): void;

    /**
     * Return custom parameter
     * 
     * @return mixed
     */
    public function getCustomParameter(string $name);
}
