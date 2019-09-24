<?php

namespace Fig\Link;

use Psr\Link\LinkInterface;
use Psr\Link\EvolvableLinkProviderInterface;

/**
 * Class EvolvableLinkProviderTrait
 *
 * @implements EvolvableLinkProviderInterface
 */
trait EvolvableLinkProviderTrait
{
    use LinkProviderTrait;

    /**
     * {@inheritdoc}
     */
    public function withLink(LinkInterface $link)
    {
        $that = clone($this);
        $splosh = spl_object_hash($link);
        if (!array_key_exists($splosh, $that->links)) {
            $that->links[$splosh] = $link;
        }
        return $that;
    }

    /**
     * {@inheritdoc}
     */
    public function withoutLink(LinkInterface $link)
    {
        $that = clone($this);
        $splosh = spl_object_hash($link);
        unset($that->links[$splosh]);
        return $that;
    }
}
