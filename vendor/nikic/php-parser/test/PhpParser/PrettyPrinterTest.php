<?php declare(strict_types=1);

namespace PhpParser;

use PhpParser\Node\Expr;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\Encapsed;
use PhpParser\Node\Scalar\EncapsedStringPart;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt;
use PhpParser\PrettyPrinter\Standard;

class PrettyPrinterTest extends CodeTestAbstract
{
    protected function doTestPrettyPrintMethod($method, $name, $code, $expected, $modeLine) {
        $lexer = new Lexer\Emulative;
        $parser5 = new Parser\Php5($lexer);
        $parser7 = new Parser\Php7($lexer);

        list($version, $options) = $this->parseModeLine($modeLine);
        $prettyPrinter = new Standard($options);

        try {
            $output5 = canonicalize($prettyPrinter->$method($parser5->parse($code)));
        } catch (Error $e) {
            $output5 = null;
            if ('php7' !== $version) {
                throw $e;
            }
        }

        try {
            $output7 = canonicalize($prettyPrinter->$method($parser7->parse($code)));
        } catch (Error $e) {
            $output7 = null;
            if ('php5' !== $version) {
                throw $e;
            }
        }

        if ('php5' === $version) {
            $this->assertSame($expected, $output5, $name);
            $this->assertNotSame($expected, $output7, $name);
        } elseif ('php7' === $version) {
            $this->assertSame($expected, $output7, $name);
            $this->assertNotSame($expected, $output5, $name);
        } else {
            $this->assertSame($expected, $output5, $name);
            $this->assertSame($expected, $output7, $name);
        }
    }

    /**
     * @dataProvider provideTestPrettyPrint
     * @covers \PhpParser\PrettyPrinter\Standard<extended>
     */
    public function testPrettyPrint($name, $code, $expected, $mode) {
        $this->doTestPrettyPrintMethod('prettyPrint', $name, $code, $expected, $mode);
    }

    /**
     * @dataProvider provideTestPrettyPrintFile
     * @covers \PhpParser\PrettyPrinter\Standard<extended>
     */
    public function testPrettyPrintFile($name, $code, $expected, $mode) {
        $this->doTestPrettyPrintMethod('prettyPrintFile', $name, $code, $expected, $mode);
    }

    public function provideTestPrettyPrint() {
        return $this->getTests(__DIR__ . '/../code/prettyPrinter', 'test');
    }

    public function provideTestPrettyPrintFile() {
        return $this->getTests(__DIR__ . '/../code/prettyPrinter', 'file-test');
    }

    public function testPrettyPrintExpr() {
        $prettyPrinter = new Standard;
        $expr = new Expr\BinaryOp\Mul(
            new Expr\BinaryOp\Plus(new Expr\Variable('a'), new Expr\Variable('b')),
            new Expr\Variable('c')
        );
        $this->assertEquals('($a + $b) * $c', $prettyPrinter->prettyPrintExpr($expr));

        $expr = new Expr\Closure([
            'stmts' => [new Stmt\Return_(new String_("a\nb"))]
        ]);
        $this->assertEquals("function () {\n    return 'a\nb';\n}", $prettyPrinter->prettyPrintExpr($expr));
    }

    public function testCommentBeforeInlineHTML() {
        $prettyPrinter = new PrettyPrinter\Standard;
        $comment = new Comment\Doc("/**\n * This is a comment\n */");
        $stmts = [new Stmt\InlineHTML('Hello World!', ['comments' => [$comment]])];
        $expected = "<?php\n\n/**\n * This is a comment\n */\n?>\nHello World!";
        $this->assertSame($expected, $prettyPrinter->prettyPrintFile($stmts));
    }

    private function parseModeLine($modeLine) {
        $parts = explode(' ', (string) $modeLine, 2);
        $version = $parts[0] ?? 'both';
        $options = isset($parts[1]) ? json_decode($parts[1], true) : [];
        return [$version, $options];
    }

    public function testArraySyntaxDefault() {
        $prettyPrinter = new Standard(['shortArraySyntax' => true]);
        $expr = new Expr\Array_([
            new Expr\ArrayItem(new String_('val'), new String_('key'))
        ]);
        $expected = "['key' => 'val']";
        $this->assertSame($expected, $prettyPrinter->prettyPrintExpr($expr));
    }

    /**
     * @dataProvider provideTestKindAttributes
     */
    public function testKindAttributes($node, $expected) {
        $prttyPrinter = new PrettyPrinter\Standard;
        $result = $prttyPrinter->prettyPrintExpr($node);
        $this->assertSame($expected, $result);
    }

    public function provideTestKindAttributes() {
        $nowdoc = ['kind' => String_::KIND_NOWDOC, 'docLabel' => 'STR'];
        $heredoc = ['kind' => String_::KIND_HEREDOC, 'docLabel' => 'STR'];
        return [
            // Defaults to single quoted
            [new String_('foo'), "'foo'"],
            // Explicit single/double quoted
            [new String_('foo', ['kind' => String_::KIND_SINGLE_QUOTED]), "'foo'"],
            [new String_('foo', ['kind' => String_::KIND_DOUBLE_QUOTED]), '"foo"'],
            // Fallback from doc string if no label
            [new String_('foo', ['kind' => String_::KIND_NOWDOC]), "'foo'"],
            [new String_('foo', ['kind' => String_::KIND_HEREDOC]), '"foo"'],
            // Fallback if string contains label
            [new String_("A\nB\nC", ['kind' => String_::KIND_NOWDOC, 'docLabel' => 'A']), "'A\nB\nC'"],
            [new String_("A\nB\nC", ['kind' => String_::KIND_NOWDOC, 'docLabel' => 'B']), "'A\nB\nC'"],
            [new String_("A\nB\nC", ['kind' => String_::KIND_NOWDOC, 'docLabel' => 'C']), "'A\nB\nC'"],
            [new String_("STR;", ['kind' => String_::KIND_NOWDOC, 'docLabel' => 'STR']), "'STR;'"],
            // Doc string if label not contained (or not in ending position)
            [new String_("foo", $nowdoc), "<<<'STR'\nfoo\nSTR\n"],
            [new String_("foo", $heredoc), "<<<STR\nfoo\nSTR\n"],
            [new String_("STRx", $nowdoc), "<<<'STR'\nSTRx\nSTR\n"],
            [new String_("xSTR", $nowdoc), "<<<'STR'\nxSTR\nSTR\n"],
            // Empty doc string variations (encapsed variant does not occur naturally)
            [new String_("", $nowdoc), "<<<'STR'\nSTR\n"],
            [new String_("", $heredoc), "<<<STR\nSTR\n"],
            [new Encapsed([new EncapsedStringPart('')], $heredoc), "<<<STR\nSTR\n"],
            // Encapsed doc string variations
            [new Encapsed([new EncapsedStringPart('foo')], $heredoc), "<<<STR\nfoo\nSTR\n"],
            [new Encapsed([new EncapsedStringPart('foo'), new Expr\Variable('y')], $heredoc), "<<<STR\nfoo{\$y}\nSTR\n"],
            [new Encapsed([new EncapsedStringPart("\nSTR"), new Expr\Variable('y')], $heredoc), "<<<STR\n\nSTR{\$y}\nSTR\n"],
            [new Encapsed([new EncapsedStringPart("\nSTR"), new Expr\Variable('y')], $heredoc), "<<<STR\n\nSTR{\$y}\nSTR\n"],
            [new Encapsed([new Expr\Variable('y'), new EncapsedStringPart("STR\n")], $heredoc), "<<<STR\n{\$y}STR\n\nSTR\n"],
            // Encapsed doc string fallback
            [new Encapsed([new Expr\Variable('y'), new EncapsedStringPart("\nSTR")], $heredoc), '"{$y}\\nSTR"'],
            [new Encapsed([new EncapsedStringPart("STR\n"), new Expr\Variable('y')], $heredoc), '"STR\\n{$y}"'],
            [new Encapsed([new EncapsedStringPart("STR")], $heredoc), '"STR"'],
        ];
    }

    /** @dataProvider provideTestUnnaturalLiterals */
    public function testUnnaturalLiterals($node, $expected) {
        $prttyPrinter = new PrettyPrinter\Standard;
        $result = $prttyPrinter->prettyPrintExpr($node);
        $this->assertSame($expected, $result);
    }

    public function provideTestUnnaturalLiterals() {
        return [
            [new LNumber(-1), '-1'],
            [new LNumber(-PHP_INT_MAX - 1), '(-' . PHP_INT_MAX . '-1)'],
            [new LNumber(-1, ['kind' => LNumber::KIND_BIN]), '-0b1'],
            [new LNumber(-1, ['kind' => LNumber::KIND_OCT]), '-01'],
            [new LNumber(-1, ['kind' => LNumber::KIND_HEX]), '-0x1'],
            [new DNumber(\INF), '\INF'],
            [new DNumber(-\INF), '-\INF'],
            [new DNumber(-\NAN), '\NAN'],
        ];
    }

    public function testPrettyPrintWithError() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot pretty-print AST with Error nodes');
        $stmts = [new Stmt\Expression(
            new Expr\PropertyFetch(new Expr\Variable('a'), new Expr\Error())
        )];
        $prettyPrinter = new PrettyPrinter\Standard;
        $prettyPrinter->prettyPrint($stmts);
    }

    public function testPrettyPrintWithErrorInClassConstFetch() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot pretty-print AST with Error nodes');
        $stmts = [new Stmt\Expression(
            new Expr\ClassConstFetch(new Name('Foo'), new Expr\Error())
        )];
        $prettyPrinter = new PrettyPrinter\Standard;
        $prettyPrinter->prettyPrint($stmts);
    }

    public function testPrettyPrintEncapsedStringPart() {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Cannot directly print EncapsedStringPart');
        $expr = new Node\Scalar\EncapsedStringPart('foo');
        $prettyPrinter = new PrettyPrinter\Standard;
        $prettyPrinter->prettyPrintExpr($expr);
    }

    /**
     * @dataProvider provideTestFormatPreservingPrint
     * @covers \PhpParser\PrettyPrinter\Standard<extended>
     */
    public function testFormatPreservingPrint($name, $code, $modification, $expected, $modeLine) {
        $lexer = new Lexer\Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);

        $parser = new Parser\Php7($lexer);
        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NodeVisitor\CloningVisitor());

        $printer = new PrettyPrinter\Standard();

        $oldStmts = $parser->parse($code);
        $oldTokens = $lexer->getTokens();

        $newStmts = $traverser->traverse($oldStmts);

        /** @var callable $fn */
        eval(<<<CODE
use PhpParser\Comment;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar;
use PhpParser\Node\Stmt;
\$fn = function(&\$stmts) { $modification };
CODE
        );
        $fn($newStmts);

        $newCode = $printer->printFormatPreserving($newStmts, $oldStmts, $oldTokens);
        $this->assertSame(canonicalize($expected), canonicalize($newCode), $name);
    }

    public function provideTestFormatPreservingPrint() {
        return $this->getTests(__DIR__ . '/../code/formatPreservation', 'test', 3);
    }

    /**
     * @dataProvider provideTestRoundTripPrint
     * @covers \PhpParser\PrettyPrinter\Standard<extended>
     */
    public function testRoundTripPrint($name, $code, $expected, $modeLine) {
        /**
         * This test makes sure that the format-preserving pretty printer round-trips for all
         * the pretty printer tests (i.e. returns the input if no changes occurred).
         */

        list($version) = $this->parseModeLine($modeLine);

        $lexer = new Lexer\Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);

        $parserClass = $version === 'php5' ? Parser\Php5::class : Parser\Php7::class;
        /** @var Parser $parser */
        $parser = new $parserClass($lexer);

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NodeVisitor\CloningVisitor());

        $printer = new PrettyPrinter\Standard();

        try {
            $oldStmts = $parser->parse($code);
        } catch (Error $e) {
            // Can't do a format-preserving print on a file with errors
            return;
        }

        $oldTokens = $lexer->getTokens();

        $newStmts = $traverser->traverse($oldStmts);

        $newCode = $printer->printFormatPreserving($newStmts, $oldStmts, $oldTokens);
        $this->assertSame(canonicalize($code), canonicalize($newCode), $name);
    }

    public function provideTestRoundTripPrint() {
        return array_merge(
            $this->getTests(__DIR__ . '/../code/prettyPrinter', 'test'),
            $this->getTests(__DIR__ . '/../code/parser', 'test')
        );
    }
}
