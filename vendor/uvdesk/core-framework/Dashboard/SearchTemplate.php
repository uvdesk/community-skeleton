<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Dashboard;

use Twig\Environment as TwigEnvironment;
use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Framework\ExtendableComponentInterface;

class SearchTemplate implements ExtendableComponentInterface
{
    private $collection = [];

    public function __construct(TwigEnvironment $twig)
    {
        $this->twig = $twig;
    }

    public function appendSearchItem(SearchItemInterface $segment, $tags = [])
    {
        $this->collection[] = $segment;
    }

    public function render()
    {
        return $this->twig->render('@UVDeskCoreFramework/Templates/search.html.twig', [
            'collection' => $this->collection
        ]);
    }
}
