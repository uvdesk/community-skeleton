<?php

namespace Test\Tool;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Base test case
 */
abstract class BaseTestCase extends TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

    }

    protected function createRequestStack(array $params): RequestStack
    {
        $request = new Request($params);
        $requestStack = new RequestStack();
        $requestStack->push($request);

        return $requestStack;
    }
}