<?php

namespace Knp\Component\Pager\Pagination;

use Closure;

/**
 * @todo: find a way to avoid exposing private member setters
 *
 * Sliding pagination
 */
class SlidingPagination extends AbstractPagination
{
    /**
     * Pagination page range
     *
     * @var integer
     */
    private $range = 5;

    /**
     * Closure which is executed to render pagination
     *
     * @var Closure
     */
    public $renderer;

    public function setPageRange(int $range): void
    {
        $this->range = intval(abs($range));
    }

    /**
     * Renders the pagination
     */
    public function __toString(): string
    {
        $data = $this->getPaginationData();
        $output = '';
        if (!$this->renderer instanceof Closure) {
            $output = 'override in order to render a template';
        } else {
            $output = call_user_func($this->renderer, $data);
        }
        return $output;
    }

    public function getPaginationData(): array
    {
        $pageCount = intval(ceil($this->totalCount / $this->numItemsPerPage));
        $current = $this->currentPageNumber;

        if ($this->range > $pageCount) {
            $this->range = $pageCount;
        }

        $delta = ceil($this->range / 2);

        if ($current - $delta > $pageCount - $this->range) {
            $pages = range($pageCount - $this->range + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }

            $offset = $current - $delta;
            $pages = range($offset + 1, $offset + $this->range);
        }

        $viewData = [
            'last' => $pageCount,
            'current' => $current,
            'numItemsPerPage' => $this->numItemsPerPage,
            'first' => 1,
            'pageCount' => $pageCount,
            'totalCount' => $this->totalCount,
        ];
        $viewData = array_merge($viewData, $this->paginatorOptions, $this->customParameters);

        if ($current - 1 > 0) {
            $viewData['previous'] = $current - 1;
        }

        if ($current + 1 <= $pageCount) {
            $viewData['next'] = $current + 1;
        }
        $viewData['pagesInRange'] = $pages;
        $viewData['firstPageInRange'] = min($pages);
        $viewData['lastPageInRange']  = max($pages);

        if ($this->getItems() !== null) {
            $viewData['currentItemCount'] = $this->count();
            $viewData['firstItemNumber'] = (($current - 1) * $this->numItemsPerPage) + 1;
            $viewData['lastItemNumber'] = $viewData['firstItemNumber'] + $viewData['currentItemCount'] - 1;
        }

        return $viewData;
    }
}
