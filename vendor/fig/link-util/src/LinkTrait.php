<?php

namespace Fig\Link;

use Psr\Link\LinkInterface;

/**
 * Class LinkTrait
 *
 * @inherits LinkInterface
 */
trait LinkTrait
{
    use TemplatedHrefTrait;

    /**
     *
     *
     * @var string
     */
    private $href = '';

    /**
     * The set of rels on this link.
     *
     * Note: Because rels are an exclusive set, we use the keys of the array
     * to store the rels that have been added, not the values. The values
     * are simply boolean true.  A rel is present if the key is set, false
     * otherwise.
     *
     * @var string[]
     */
    private $rel = [];

    /**
     *
     *
     * @var string
     */
    private $attributes = [];

    /**
     * {@inheritdoc}
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * {@inheritdoc}
     */
    public function isTemplated()
    {
        return $this->hrefIsTemplated($this->href);
    }

    /**
     * {@inheritdoc}
     */
    public function getRels()
    {
        return array_keys($this->rel);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
