<?php

namespace Knp\Component\Pager\Event;

/**
 * Specific Event class for paginator
 */
class ItemsEvent extends Event
{
    /**
     * A target being paginated
     *
     * @var mixed
     */
    public $target;

    /**
     * List of options
     *
     * @var array
     */
    public $options;

    /**
     * Items result
     *
     * @var mixed
     */
    public $items;

    /**
     * Count result
     *
     * @var integer
     */
    public $count;

    private $offset;
    private $limit;
    private $customPaginationParams = [];

    public function __construct(int $offset, int $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function setCustomPaginationParameter($name, $value): void
    {
        $this->customPaginationParams[$name] = $value;
    }

    public function getCustomPaginationParameters(): array
    {
        return $this->customPaginationParams;
    }

    public function unsetCustomPaginationParameter($name): void
    {
        if (isset($this->customPaginationParams[$name])) {
            unset($this->customPaginationParams[$name]);
        }
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
