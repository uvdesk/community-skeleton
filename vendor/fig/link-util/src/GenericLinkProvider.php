<?php

namespace Fig\Link;

use Psr\Link\EvolvableLinkProviderInterface;
use Psr\Link\LinkInterface;

class GenericLinkProvider implements EvolvableLinkProviderInterface
{
    use EvolvableLinkProviderTrait;

    /**
     * Constructs a new link provider.
     *
     * @param LinkInterface[] $links
     *   Optionally, specify an initial set of links for this provider.
     *   Note that the keys of the array will be ignored.
     */
    public function __construct(array $links = [])
    {
        // This block will throw a type error if any item isn't a LinkInterface, by design.
        array_filter($links, function (LinkInterface $item) {
            return true;
        });

        $hashes = array_map('spl_object_hash', $links);
        $this->links = array_combine($hashes, $links);
    }
}
