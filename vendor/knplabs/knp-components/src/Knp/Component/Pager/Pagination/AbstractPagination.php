<?php

namespace Knp\Component\Pager\Pagination;

use Iterator;

abstract class AbstractPagination implements Iterator, PaginationInterface
{
    protected $currentPageNumber;
    protected $numItemsPerPage;
    protected $items = [];
    protected $totalCount;
    protected $paginatorOptions;
    protected $customParameters;

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        reset($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function key() 
    {
        return key($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function next(): void
    {
        next($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        return key($this->items) !== null;
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->items);
    }

    public function setCustomParameters(array $parameters): void
    {
        $this->customParameters = $parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function getCustomParameter(string $name)
    {
        return $this->customParameters[$name] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentPageNumber(int $pageNumber): void
    {
        $this->currentPageNumber = $pageNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function setItemNumberPerPage(int $numItemsPerPage): void
    {
        $this->numItemsPerPage = $numItemsPerPage;
    }

    /**
     * {@inheritDoc}
     */
    public function getItemNumberPerPage(): int
    {
        return $this->numItemsPerPage;
    }

    /**
     * {@inheritDoc}
     */
    public function setTotalItemCount(int $numTotal): void
    {
        $this->totalCount = $numTotal;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalItemCount(): int
    {
        return $this->totalCount;
    }

    /**
     * {@inheritDoc}
     */
    public function setPaginatorOptions(array $options): void
    {
        $this->paginatorOptions = $options;
    }

    /**
     * {@inheritDoc}
     */
    public function getPaginatorOption($name)
    {
        return isset($this->paginatorOptions[$name]) ? $this->paginatorOptions[$name] : null;
    }

    /**
     * {@inheritDoc}
     */
    public function setItems(iterable $items): void
    {
        $this->items = $items;
    }

    /**
     * {@inheritDoc}
     */
    public function getItems(): iterable
    {
        return $this->items;
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }
}
