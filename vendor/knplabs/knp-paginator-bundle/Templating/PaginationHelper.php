<?php

namespace Knp\Bundle\PaginatorBundle\Templating;

use Knp\Bundle\PaginatorBundle\Helper\Processor;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\PhpEngine;

/**
 * Pagination PHP helper.
 *
 * Basically provides access to KnpPaginator from PHP templates
 *
 * @author Rafa³ Wrzeszcz <rafal.wrzeszcz@wrzasq.pl>
 */
final class PaginationHelper extends Helper
{
    /**
     * @var PhpEngine
     */
    protected $templating;

    /**
     * @var Processor
     */
    protected $processor;

    public function __construct(Processor $processor, PhpEngine $templating)
    {
        $this->processor = $processor;
        $this->templating = $templating;
    }

    /**
     * Renders the pagination template.
     *
     * @param SlidingPagination $pagination
     * @param string            $template
     * @param array             $queryParams
     * @param array             $viewParams
     *
     * @return string
     */
    public function render(SlidingPagination $pagination, $template = null, array $queryParams = [], array $viewParams = [])
    {
        return $this->templating->render(
            $template ?: $pagination->getTemplate(),
            $this->processor->render($pagination, $queryParams, $viewParams)
        );
    }

    /**
     * Create a sort url for the field named $title
     * and identified by $key which consists of
     * alias and field. $options holds all link
     * parameters like "alt, class" and so on.
     *
     * $key example: "article.title"
     *
     * @param SlidingPagination $pagination
     * @param string            $title
     * @param string            $key
     * @param array             $options
     * @param array             $params
     * @param string            $template
     *
     * @return string
     */
    public function sortable(SlidingPagination $pagination, $title, $key, $options = [], $params = [], $template = null)
    {
        return $this->templating->render(
            $template ?: $pagination->getSortableTemplate(),
            $this->processor->sortable($pagination, $title, $key, $options, $params)
        );
    }

    /**
     * Create a filter url for the field named $title
     * and identified by $key which consists of
     * alias and field. $options holds all link
     * parameters like "alt, class" and so on.
     *
     * $key example: "article.title"
     *
     * @param SlidingPagination $pagination
     * @param array             $fields
     * @param array             $options
     * @param array             $params
     * @param string            $template
     *
     * @return string
     */
    public function filter(SlidingPagination $pagination, array $fields, $options = [], $params = [], $template = null)
    {
        return $this->templating->render(
            $template ?: $pagination->getFiltrationTemplate(),
            $this->processor->filter($pagination, $fields, $options, $params)
        );
    }

    /**
     * Get helper name.
     *
     * @return string
     */
    public function getName()
    {
        return 'knp_pagination';
    }
}
