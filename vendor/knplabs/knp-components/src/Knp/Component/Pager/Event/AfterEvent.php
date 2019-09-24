<?php

namespace Knp\Component\Pager\Event;

use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Specific Event class for paginator
 */
class AfterEvent extends Event
{
    private $pagination;

    public function __construct(PaginationInterface $paginationView)
    {
        $this->pagination = $paginationView;
    }

    public function getPaginationView(): PaginationInterface
    {
        return $this->pagination;
    }
}
