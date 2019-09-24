<?php

namespace Test\Pager\Pagination;

use Knp\Component\Pager\Paginator;
use Test\Tool\BaseTestCase;

final class PaginatorTest extends BaseTestCase
{
    /**
     * @test
     */
    public function shouldThrowExceptionOnInvalidPageAndLimitArgs(): void
    {
        $exceptionTrown = false;
        try {
            (new Paginator())->paginate(['a', 'b'], -1, 0);
        } catch (\LogicException $e) {
            $exceptionTrown = true;
        }
        $this->assertTrue($exceptionTrown);
    }
}
