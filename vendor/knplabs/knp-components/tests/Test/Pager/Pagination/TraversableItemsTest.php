<?php

namespace Test\Pager\Pagination;

use Knp\Component\Pager\Paginator;
use Test\Tool\BaseTestCase;

final class TraversableItemsTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldBeAbleToUseTraversableItems(): void
    {
        $p = new Paginator;

        $items = new \ArrayObject(range(1, 23));
        $view = $p->paginate($items, 3, 10);

        $view->renderer = function($data) {
            return 'custom';
        };
        $this->assertEquals('custom', (string)$view);

        $items = $view->getItems();
        $this->assertInstanceOf(\ArrayObject::class, $items);
        $i = 21;
        foreach ($view as $item) {
            $this->assertEquals($i++, $item);
        }
    }
}
