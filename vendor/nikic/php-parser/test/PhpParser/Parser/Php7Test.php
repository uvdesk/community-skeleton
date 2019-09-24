<?php declare(strict_types=1);

namespace PhpParser\Parser;

use PhpParser\Lexer;
use PhpParser\ParserTest;

class Php7Test extends ParserTest
{
    protected function getParser(Lexer $lexer) {
        return new Php7($lexer);
    }
}
