<?php

namespace Knp\Bundle\PaginatorBundle\Twig\Extension;

use Knp\Bundle\PaginatorBundle\Helper\Processor;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class PaginationExtension extends AbstractExtension
{
    /**
     * @var Processor
     */
    private $processor;

    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('knp_pagination_render', [$this, 'render'], ['is_safe' => ['html'], 'needs_environment' => true]),
            new TwigFunction('knp_pagination_sortable', [$this, 'sortable'], ['is_safe' => ['html'], 'needs_environment' => true]),
            new TwigFunction('knp_pagination_filter', [$this, 'filter'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    /**
     * Renders the pagination template.
     *
     * @param Environment       $env
     * @param SlidingPagination $pagination
     * @param string|null       $template
     * @param array|null        $queryParams
     * @param array|null        $viewParams
     *
     * @return string
     */
    public function render(Environment $env, SlidingPagination $pagination, ?string $template = null, ?array $queryParams = [], ?array $viewParams = []): string
    {
        return $env->render(
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
     * @param Environment       $env
     * @param SlidingPagination $pagination
     * @param string            $title
     * @param string            $key
     * @param array             $options
     * @param array             $params
     * @param string            $template
     *
     * @return string
     */
    public function sortable(Environment $env, SlidingPagination $pagination, string $title, string $key, array $options = [], array $params = [], string $template = null): string
    {
        return $env->render(
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
     * @param Environment       $env
     * @param SlidingPagination $pagination
     * @param array             $fields
     * @param array|null        $options
     * @param array|null        $params
     * @param string|null       $template
     *
     * @return string
     */
    public function filter(Environment $env, SlidingPagination $pagination, array $fields, ?array $options = [], ?array $params = [], ?string $template = null): string
    {
        return $env->render(
            $template ?: $pagination->getFiltrationTemplate(),
            $this->processor->filter($pagination, $fields, $options, $params)
        );
    }
}
