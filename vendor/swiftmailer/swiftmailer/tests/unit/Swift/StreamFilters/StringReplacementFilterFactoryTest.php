<?php

class Swift_StreamFilters_StringReplacementFilterFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testInstancesOfStringReplacementFilterAreCreated()
    {
        $factory = $this->createFactory();
        $this->assertInstanceOf(
            'Swift_StreamFilters_StringReplacementFilter',
            $factory->createFilter('a', 'b')
        );
    }

    public function testSameInstancesAreCached()
    {
        $factory = $this->createFactory();
        $filter1 = $factory->createFilter('a', 'b');
        $filter2 = $factory->createFilter('a', 'b');
        $this->assertSame($filter1, $filter2, '%s: Instances should be cached');
    }

    public function testDifferingInstancesAreNotCached()
    {
        $factory = $this->createFactory();
        $filter1 = $factory->createFilter('a', 'b');
        $filter2 = $factory->createFilter('a', 'c');
        $this->assertNotEquals($filter1, $filter2,
            '%s: Differing instances should not be cached'
            );
    }

    private function createFactory()
    {
        return new Swift_StreamFilters_StringReplacementFilterFactory();
    }
}
