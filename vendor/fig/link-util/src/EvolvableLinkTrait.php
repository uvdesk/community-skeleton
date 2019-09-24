<?php


namespace Fig\Link;

use Psr\Link\EvolvableLinkInterface;

/**
 * Class EvolvableLinkTrait
 *
 * @implements EvolvableLinkInterface
 */
trait EvolvableLinkTrait
{
    use LinkTrait;

    /**
     * {@inheritdoc}
     *
     * @return EvolvableLinkInterface
     */
    public function withHref($href)
    {
        /** @var EvolvableLinkInterface $that */
        $that = clone($this);
        $that->href = $href;

        $that->templated = ($this->hrefIsTemplated($href));

        return $that;
    }

    /**
     * {@inheritdoc}
     *
     * @return EvolvableLinkInterface
     */
    public function withRel($rel)
    {
        /** @var EvolvableLinkInterface $that */
        $that = clone($this);
        $that->rel[$rel] = true;
        return $that;
    }

    /**
     * {@inheritdoc}
     *
     * @return EvolvableLinkInterface
     */
    public function withoutRel($rel)
    {
        /** @var EvolvableLinkInterface $that */
        $that = clone($this);
        unset($that->rel[$rel]);
        return $that;
    }

    /**
     * {@inheritdoc}
     *
     * @return EvolvableLinkInterface
     */
    public function withAttribute($attribute, $value)
    {
        /** @var EvolvableLinkInterface $that */
        $that = clone($this);
        $that->attributes[$attribute] = $value;
        return $that;
    }

    /**
     * {@inheritdoc}
     *
     * @return EvolvableLinkInterface
     */
    public function withoutAttribute($attribute)
    {
        /** @var EvolvableLinkInterface $that */
        $that = clone($this);
        unset($that->attributes[$attribute]);
        return $that;
    }
}
