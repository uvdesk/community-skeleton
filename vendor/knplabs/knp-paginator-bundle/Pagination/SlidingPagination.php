<?php

namespace Knp\Bundle\PaginatorBundle\Pagination;

use Knp\Component\Pager\Pagination\AbstractPagination;

final class SlidingPagination extends AbstractPagination
{
    private $route;
    private $params;
    private $pageRange = 5;
    private $template;
    private $sortableTemplate;
    private $filtrationTemplate;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function setUsedRoute($route): void
    {
        $this->route = $route;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setSortableTemplate($template): void
    {
        $this->sortableTemplate = $template;
    }

    public function getSortableTemplate()
    {
        return $this->sortableTemplate;
    }

    public function setFiltrationTemplate($template): void
    {
        $this->filtrationTemplate = $template;
    }

    public function getFiltrationTemplate()
    {
        return $this->filtrationTemplate;
    }

    public function setParam($name, $value): void
    {
        $this->params[$name] = $value;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setTemplate($template): void
    {
        $this->template = $template;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setPageRange($range): void
    {
        $this->pageRange = \abs((int) $range);
    }

    /**
     * Get url query with all parameters.
     *
     * @param array $additionalQueryParams
     *
     * @return array - list of query parameters
     */
    public function getQuery(array $additionalQueryParams = [])
    {
        return \array_merge($this->params, $additionalQueryParams);
    }

    public function isSorted($key = null, array $params = [])
    {
        $params = \array_merge($this->params, $params);

        if (null === $key) {
            return isset($params[$this->getPaginatorOption('sortFieldParameterName')]);
        }

        return isset($params[$this->getPaginatorOption('sortFieldParameterName')]) && $params[$this->getPaginatorOption('sortFieldParameterName')] === $key;
    }

    public function getPage()
    {
        if (\array_key_exists($this->getPaginatorOption('pageParameterName'), $this->params)) {
            return $this->params[$this->getPaginatorOption('pageParameterName')];
        }

        return null;
    }

    public function getSort()
    {
        if (\array_key_exists($this->getPaginatorOption('sortFieldParameterName'), $this->params)) {
            return $this->params[$this->getPaginatorOption('sortFieldParameterName')];
        }

        return null;
    }

    public function getDirection()
    {
        if (\array_key_exists($this->getPaginatorOption('sortDirectionParameterName'), $this->params)) {
            return $this->params[$this->getPaginatorOption('sortDirectionParameterName')];
        }

        return null;
    }

    public function getPaginationData()
    {
        $pageCount = $this->getPageCount();
        $current = $this->currentPageNumber;

        if ($pageCount < $current) {
            $this->currentPageNumber = $current = $pageCount;
        }

        if ($this->pageRange > $pageCount) {
            $this->pageRange = $pageCount;
        }

        $delta = \ceil($this->pageRange / 2);

        if ($current - $delta > $pageCount - $this->pageRange) {
            $pages = \range($pageCount - $this->pageRange + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }

            $offset = $current - $delta;
            $pages = \range($offset + 1, $offset + $this->pageRange);
        }

        $proximity = \floor($this->pageRange / 2);

        $startPage = $current - $proximity;
        $endPage = $current + $proximity;

        if ($startPage < 1) {
            $endPage = \min($endPage + (1 - $startPage), $pageCount);
            $startPage = 1;
        }

        if ($endPage > $pageCount) {
            $startPage = \max($startPage - ($endPage - $pageCount), 1);
            $endPage = $pageCount;
        }

        $viewData = [
            'last' => $pageCount,
            'current' => $current,
            'numItemsPerPage' => $this->numItemsPerPage,
            'first' => 1,
            'pageCount' => $pageCount,
            'totalCount' => $this->totalCount,
            'pageRange' => $this->pageRange,
            'startPage' => $startPage,
            'endPage' => $endPage,
        ];

        if ($current > 1) {
            $viewData['previous'] = $current - 1;
        }

        if ($current < $pageCount) {
            $viewData['next'] = $current + 1;
        }

        $viewData['pagesInRange'] = $pages;
        $viewData['firstPageInRange'] = \min($pages);
        $viewData['lastPageInRange'] = \max($pages);

        if (null !== $this->getItems()) {
            $viewData['currentItemCount'] = $this->count();
            $viewData['firstItemNumber'] = 0;
            $viewData['lastItemNumber'] = 0;
            if ($viewData['totalCount'] > 0) {
                $viewData['firstItemNumber'] = (($current - 1) * $this->numItemsPerPage) + 1;
                $viewData['lastItemNumber'] = $viewData['firstItemNumber'] + $viewData['currentItemCount'] - 1;
            }
        }

        return $viewData;
    }

    public function getPageCount()
    {
        return (int) (\ceil($this->totalCount / $this->numItemsPerPage));
    }

    public function getPaginatorOptions()
    {
        return $this->paginatorOptions;
    }

    public function getCustomParameters()
    {
        return $this->customParameters;
    }
}
