<?php

class Swift_StreamFilters_StringReplacementFilterTest extends \PHPUnit\Framework\TestCase
{
    public function testBasicReplacementsAreMade()
    {
        $filter = $this->createFilter('foo', 'bar');
        $this->assertEquals('XbarYbarZ', $filter->filter('XfooYfooZ'));
    }

    public function testShouldBufferReturnsTrueIfPartialMatchAtEndOfBuffer()
    {
        $filter = $this->createFilter('foo', 'bar');
        $this->assertTrue($filter->shouldBuffer('XfooYf'),
            '%s: Filter should buffer since "foo" is the needle and the ending '.
            '"f" could be from "foo"'
            );
    }

    public function testFilterCanMakeMultipleReplacements()
    {
        $filter = $this->createFilter(['a', 'b'], 'foo');
        $this->assertEquals('XfooYfooZ', $filter->filter('XaYbZ'));
    }

    public function testMultipleReplacementsCanBeDifferent()
    {
        $filter = $this->createFilter(['a', 'b'], ['foo', 'zip']);
        $this->assertEquals('XfooYzipZ', $filter->filter('XaYbZ'));
    }

    public function testShouldBufferReturnsFalseIfPartialMatchNotAtEndOfString()
    {
        $filter = $this->createFilter("\r\n", "\n");
        $this->assertFalse($filter->shouldBuffer("foo\r\nbar"),
            '%s: Filter should not buffer since x0Dx0A is the needle and is not at EOF'
            );
    }

    public function testShouldBufferReturnsTrueIfAnyOfMultipleMatchesAtEndOfString()
    {
        $filter = $this->createFilter(['foo', 'zip'], 'bar');
        $this->assertTrue($filter->shouldBuffer('XfooYzi'),
            '%s: Filter should buffer since "zip" is a needle and the ending '.
            '"zi" could be from "zip"'
            );
    }

    public function testShouldBufferReturnsFalseOnEmptyBuffer()
    {
        $filter = $this->createFilter("\r\n", "\n");
        $this->assertFalse($filter->shouldBuffer(''));
    }

    private function createFilter($search, $replace)
    {
        return new Swift_StreamFilters_StringReplacementFilter($search, $replace);
    }
}
