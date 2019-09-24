<?php declare(strict_types=1);

namespace PhpParser\Node\Scalar;

class StringTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideTestParseEscapeSequences
     */
    public function testParseEscapeSequences($expected, $string, $quote) {
        $this->assertSame(
            $expected,
            String_::parseEscapeSequences($string, $quote)
        );
    }

    /**
     * @dataProvider provideTestParse
     */
    public function testCreate($expected, $string) {
        $this->assertSame(
            $expected,
            String_::parse($string)
        );
    }

    public function provideTestParseEscapeSequences() {
        return [
            ['"',              '\\"',              '"'],
            ['\\"',            '\\"',              '`'],
            ['\\"\\`',         '\\"\\`',           null],
            ["\\\$\n\r\t\f\v", '\\\\\$\n\r\t\f\v', null],
            ["\x1B",           '\e',               null],
            [chr(255),         '\xFF',             null],
            [chr(255),         '\377',             null],
            [chr(0),           '\400',             null],
            ["\0",             '\0',               null],
            ['\xFF',           '\\\\xFF',          null],
        ];
    }

    public function provideTestParse() {
        $tests = [
            ['A', '\'A\''],
            ['A', 'b\'A\''],
            ['A', '"A"'],
            ['A', 'b"A"'],
            ['\\', '\'\\\\\''],
            ['\'', '\'\\\'\''],
        ];

        foreach ($this->provideTestParseEscapeSequences() as $i => $test) {
            // skip second and third tests, they aren't for double quotes
            if ($i !== 1 && $i !== 2) {
                $tests[] = [$test[0], '"' . $test[1] . '"'];
            }
        }

        return $tests;
    }
}
