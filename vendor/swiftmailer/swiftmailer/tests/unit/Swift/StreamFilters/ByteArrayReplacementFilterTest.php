<?php

class Swift_StreamFilters_ByteArrayReplacementFilterTest extends \PHPUnit\Framework\TestCase
{
    public function testBasicReplacementsAreMade()
    {
        $filter = $this->createFilter([0x61, 0x62], [0x63, 0x64]);
        $this->assertEquals(
            [0x59, 0x60, 0x63, 0x64, 0x65],
            $filter->filter([0x59, 0x60, 0x61, 0x62, 0x65])
            );
    }

    public function testShouldBufferReturnsTrueIfPartialMatchAtEndOfBuffer()
    {
        $filter = $this->createFilter([0x61, 0x62], [0x63, 0x64]);
        $this->assertTrue($filter->shouldBuffer([0x59, 0x60, 0x61]),
            '%s: Filter should buffer since 0x61 0x62 is the needle and the ending '.
            '0x61 could be from 0x61 0x62'
            );
    }

    public function testFilterCanMakeMultipleReplacements()
    {
        $filter = $this->createFilter([[0x61], [0x62]], [0x63]);
        $this->assertEquals(
            [0x60, 0x63, 0x60, 0x63, 0x60],
            $filter->filter([0x60, 0x61, 0x60, 0x62, 0x60])
            );
    }

    public function testMultipleReplacementsCanBeDifferent()
    {
        $filter = $this->createFilter([[0x61], [0x62]], [[0x63], [0x64]]);
        $this->assertEquals(
            [0x60, 0x63, 0x60, 0x64, 0x60],
            $filter->filter([0x60, 0x61, 0x60, 0x62, 0x60])
            );
    }

    public function testShouldBufferReturnsFalseIfPartialMatchNotAtEndOfString()
    {
        $filter = $this->createFilter([0x0D, 0x0A], [0x0A]);
        $this->assertFalse($filter->shouldBuffer([0x61, 0x62, 0x0D, 0x0A, 0x63]),
            '%s: Filter should not buffer since x0Dx0A is the needle and is not at EOF'
            );
    }

    public function testShouldBufferReturnsTrueIfAnyOfMultipleMatchesAtEndOfString()
    {
        $filter = $this->createFilter([[0x61, 0x62], [0x63]], [0x64]);
        $this->assertTrue($filter->shouldBuffer([0x59, 0x60, 0x61]),
            '%s: Filter should buffer since 0x61 0x62 is a needle and the ending '.
            '0x61 could be from 0x61 0x62'
            );
    }

    public function testConvertingAllLineEndingsToCRLFWhenInputIsLF()
    {
        $filter = $this->createFilter(
            [[0x0D, 0x0A], [0x0D], [0x0A]],
            [[0x0A], [0x0A], [0x0D, 0x0A]]
            );

        $this->assertEquals(
            [0x60, 0x0D, 0x0A, 0x61, 0x0D, 0x0A, 0x62, 0x0D, 0x0A, 0x63],
            $filter->filter([0x60, 0x0A, 0x61, 0x0A, 0x62, 0x0A, 0x63])
            );
    }

    public function testConvertingAllLineEndingsToCRLFWhenInputIsCR()
    {
        $filter = $this->createFilter(
            [[0x0D, 0x0A], [0x0D], [0x0A]],
            [[0x0A], [0x0A], [0x0D, 0x0A]]
            );

        $this->assertEquals(
            [0x60, 0x0D, 0x0A, 0x61, 0x0D, 0x0A, 0x62, 0x0D, 0x0A, 0x63],
            $filter->filter([0x60, 0x0D, 0x61, 0x0D, 0x62, 0x0D, 0x63])
            );
    }

    public function testConvertingAllLineEndingsToCRLFWhenInputIsCRLF()
    {
        $filter = $this->createFilter(
            [[0x0D, 0x0A], [0x0D], [0x0A]],
            [[0x0A], [0x0A], [0x0D, 0x0A]]
            );

        $this->assertEquals(
            [0x60, 0x0D, 0x0A, 0x61, 0x0D, 0x0A, 0x62, 0x0D, 0x0A, 0x63],
            $filter->filter([0x60, 0x0D, 0x0A, 0x61, 0x0D, 0x0A, 0x62, 0x0D, 0x0A, 0x63])
            );
    }

    public function testConvertingAllLineEndingsToCRLFWhenInputIsLFCR()
    {
        $filter = $this->createFilter(
            [[0x0D, 0x0A], [0x0D], [0x0A]],
            [[0x0A], [0x0A], [0x0D, 0x0A]]
            );

        $this->assertEquals(
            [0x60, 0x0D, 0x0A, 0x0D, 0x0A, 0x61, 0x0D, 0x0A, 0x0D, 0x0A, 0x62, 0x0D, 0x0A, 0x0D, 0x0A, 0x63],
            $filter->filter([0x60, 0x0A, 0x0D, 0x61, 0x0A, 0x0D, 0x62, 0x0A, 0x0D, 0x63])
            );
    }

    public function testConvertingAllLineEndingsToCRLFWhenInputContainsLFLF()
    {
        //Lighthouse Bug #23

        $filter = $this->createFilter(
            [[0x0D, 0x0A], [0x0D], [0x0A]],
            [[0x0A], [0x0A], [0x0D, 0x0A]]
            );

        $this->assertEquals(
            [0x60, 0x0D, 0x0A, 0x0D, 0x0A, 0x61, 0x0D, 0x0A, 0x0D, 0x0A, 0x62, 0x0D, 0x0A, 0x0D, 0x0A, 0x63],
            $filter->filter([0x60, 0x0A, 0x0A, 0x61, 0x0A, 0x0A, 0x62, 0x0A, 0x0A, 0x63])
            );
    }

    private function createFilter($search, $replace)
    {
        return new Swift_StreamFilters_ByteArrayReplacementFilter($search, $replace);
    }
}
