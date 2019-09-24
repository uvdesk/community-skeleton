<?php

namespace Knp\Component\Pager\Event\Subscriber\Paginate\Callback;

/**
 * Callback pagination.
 *
 * @author Piotr Pelczar <me@athlan.pl>
 */
class CallbackPagination
{
    /**
     * @var callable
     */
    private $count;

    /**
     * @var callable
     */
    private $items;

    /**
     * @param callable $count
     * @param callable $items
     */
    public function __construct(callable $count, callable $items)
    {
        $this->count = $count;
        $this->items = $items;
    }

    public function getPaginationCount(): int
    {
        return call_user_func($this->count);
    }

    public function getPaginationItems(int $offset, int $limit): array
    {
        return call_user_func_array($this->items, [$offset, $limit]);
    }
}
