<?php declare(strict_types=1);

namespace PhpParser;

/* This test is very weak, because PHPUnit's assertEquals assertion is way too slow dealing with the
 * large objects involved here. So we just do some basic instanceof tests instead. */

class ParserFactoryTest extends \PHPUnit\Framework\TestCase
{
    /** @dataProvider provideTestCreate */
    public function testCreate($kind, $lexer, $expected) {
        $this->assertInstanceOf($expected, (new ParserFactory)->create($kind, $lexer));
    }

    public function provideTestCreate() {
        $lexer = new Lexer();
        return [
            [
                ParserFactory::PREFER_PHP7, $lexer,
                Parser\Multiple::class
            ],
            [
                ParserFactory::PREFER_PHP5, null,
                Parser\Multiple::class
            ],
            [
                ParserFactory::ONLY_PHP7, null,
                Parser\Php7::class
            ],
            [
                ParserFactory::ONLY_PHP5, $lexer,
                Parser\Php5::class
            ]
        ];
    }
}
