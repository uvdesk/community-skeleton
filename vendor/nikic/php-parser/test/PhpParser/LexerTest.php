<?php declare(strict_types=1);

namespace PhpParser;

use PhpParser\Parser\Tokens;

class LexerTest extends \PHPUnit\Framework\TestCase
{
    /* To allow overwriting in parent class */
    protected function getLexer(array $options = []) {
        return new Lexer($options);
    }

    /**
     * @dataProvider provideTestError
     */
    public function testError($code, $messages) {
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('HHVM does not throw warnings from token_get_all()');
        }

        $errorHandler = new ErrorHandler\Collecting();
        $lexer = $this->getLexer(['usedAttributes' => [
            'comments', 'startLine', 'endLine', 'startFilePos', 'endFilePos'
        ]]);
        $lexer->startLexing($code, $errorHandler);
        $errors = $errorHandler->getErrors();

        $this->assertCount(count($messages), $errors);
        for ($i = 0; $i < count($messages); $i++) {
            $this->assertSame($messages[$i], $errors[$i]->getMessageWithColumnInfo($code));
        }
    }

    public function provideTestError() {
        return [
            ["<?php /*", ["Unterminated comment from 1:7 to 1:9"]],
            ["<?php \1", ["Unexpected character \"\1\" (ASCII 1) from 1:7 to 1:7"]],
            ["<?php \0", ["Unexpected null byte from 1:7 to 1:7"]],
            // Error with potentially emulated token
            ["<?php ?? \0", ["Unexpected null byte from 1:10 to 1:10"]],
            ["<?php\n\0\1 foo /* bar", [
                "Unexpected null byte from 2:1 to 2:1",
                "Unexpected character \"\1\" (ASCII 1) from 2:2 to 2:2",
                "Unterminated comment from 2:8 to 2:14"
            ]],
        ];
    }

    /**
     * @dataProvider provideTestLex
     */
    public function testLex($code, $options, $tokens) {
        $lexer = $this->getLexer($options);
        $lexer->startLexing($code);
        while ($id = $lexer->getNextToken($value, $startAttributes, $endAttributes)) {
            $token = array_shift($tokens);

            $this->assertSame($token[0], $id);
            $this->assertSame($token[1], $value);
            $this->assertEquals($token[2], $startAttributes);
            $this->assertEquals($token[3], $endAttributes);
        }
    }

    public function provideTestLex() {
        return [
            // tests conversion of closing PHP tag and drop of whitespace and opening tags
            [
                '<?php tokens ?>plaintext',
                [],
                [
                    [
                        Tokens::T_STRING, 'tokens',
                        ['startLine' => 1], ['endLine' => 1]
                    ],
                    [
                        ord(';'), '?>',
                        ['startLine' => 1], ['endLine' => 1]
                    ],
                    [
                        Tokens::T_INLINE_HTML, 'plaintext',
                        ['startLine' => 1, 'hasLeadingNewline' => false],
                        ['endLine' => 1]
                    ],
                ]
            ],
            // tests line numbers
            [
                '<?php' . "\n" . '$ token /** doc' . "\n" . 'comment */ $',
                [],
                [
                    [
                        ord('$'), '$',
                        ['startLine' => 2], ['endLine' => 2]
                    ],
                    [
                        Tokens::T_STRING, 'token',
                        ['startLine' => 2], ['endLine' => 2]
                    ],
                    [
                        ord('$'), '$',
                        [
                            'startLine' => 3,
                            'comments' => [
                                new Comment\Doc('/** doc' . "\n" . 'comment */', 2, 14, 5),
                            ]
                        ],
                        ['endLine' => 3]
                    ],
                ]
            ],
            // tests comment extraction
            [
                '<?php /* comment */ // comment' . "\n" . '/** docComment 1 *//** docComment 2 */ token',
                [],
                [
                    [
                        Tokens::T_STRING, 'token',
                        [
                            'startLine' => 2,
                            'comments' => [
                                new Comment('/* comment */', 1, 6, 1),
                                new Comment('// comment' . "\n", 1, 20, 3),
                                new Comment\Doc('/** docComment 1 */', 2, 31, 4),
                                new Comment\Doc('/** docComment 2 */', 2, 50, 5),
                            ],
                        ],
                        ['endLine' => 2]
                    ],
                ]
            ],
            // tests differing start and end line
            [
                '<?php "foo' . "\n" . 'bar"',
                [],
                [
                    [
                        Tokens::T_CONSTANT_ENCAPSED_STRING, '"foo' . "\n" . 'bar"',
                        ['startLine' => 1], ['endLine' => 2]
                    ],
                ]
            ],
            // tests exact file offsets
            [
                '<?php "a";' . "\n" . '// foo' . "\n" . '"b";',
                ['usedAttributes' => ['startFilePos', 'endFilePos']],
                [
                    [
                        Tokens::T_CONSTANT_ENCAPSED_STRING, '"a"',
                        ['startFilePos' => 6], ['endFilePos' => 8]
                    ],
                    [
                        ord(';'), ';',
                        ['startFilePos' => 9], ['endFilePos' => 9]
                    ],
                    [
                        Tokens::T_CONSTANT_ENCAPSED_STRING, '"b"',
                        ['startFilePos' => 18], ['endFilePos' => 20]
                    ],
                    [
                        ord(';'), ';',
                        ['startFilePos' => 21], ['endFilePos' => 21]
                    ],
                ]
            ],
            // tests token offsets
            [
                '<?php "a";' . "\n" . '// foo' . "\n" . '"b";',
                ['usedAttributes' => ['startTokenPos', 'endTokenPos']],
                [
                    [
                        Tokens::T_CONSTANT_ENCAPSED_STRING, '"a"',
                        ['startTokenPos' => 1], ['endTokenPos' => 1]
                    ],
                    [
                        ord(';'), ';',
                        ['startTokenPos' => 2], ['endTokenPos' => 2]
                    ],
                    [
                        Tokens::T_CONSTANT_ENCAPSED_STRING, '"b"',
                        ['startTokenPos' => 5], ['endTokenPos' => 5]
                    ],
                    [
                        ord(';'), ';',
                        ['startTokenPos' => 6], ['endTokenPos' => 6]
                    ],
                ]
            ],
            // tests all attributes being disabled
            [
                '<?php /* foo */ $bar;',
                ['usedAttributes' => []],
                [
                    [
                        Tokens::T_VARIABLE, '$bar',
                        [], []
                    ],
                    [
                        ord(';'), ';',
                        [], []
                    ]
                ]
            ],
            // tests no tokens
            [
                '',
                [],
                []
            ],
        ];
    }

    /**
     * @dataProvider provideTestHaltCompiler
     */
    public function testHandleHaltCompiler($code, $remaining) {
        $lexer = $this->getLexer();
        $lexer->startLexing($code);

        while (Tokens::T_HALT_COMPILER !== $lexer->getNextToken());

        $this->assertSame($remaining, $lexer->handleHaltCompiler());
        $this->assertSame(0, $lexer->getNextToken());
    }

    public function provideTestHaltCompiler() {
        return [
            ['<?php ... __halt_compiler();Remaining Text', 'Remaining Text'],
            ['<?php ... __halt_compiler ( ) ;Remaining Text', 'Remaining Text'],
            ['<?php ... __halt_compiler() ?>Remaining Text', 'Remaining Text'],
            //array('<?php ... __halt_compiler();' . "\0", "\0"),
            //array('<?php ... __halt_compiler /* */ ( ) ;Remaining Text', 'Remaining Text'),
        ];
    }

    public function testHandleHaltCompilerError() {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('__HALT_COMPILER must be followed by "();"');
        $lexer = $this->getLexer();
        $lexer->startLexing('<?php ... __halt_compiler invalid ();');

        while (Tokens::T_HALT_COMPILER !== $lexer->getNextToken());
        $lexer->handleHaltCompiler();
    }

    public function testGetTokens() {
        $code = '<?php "a";' . "\n" . '// foo' . "\n" . '"b";';
        $expectedTokens = [
            [T_OPEN_TAG, '<?php ', 1],
            [T_CONSTANT_ENCAPSED_STRING, '"a"', 1],
            ';',
            [T_WHITESPACE, "\n", 1],
            [T_COMMENT, '// foo' . "\n", 2],
            [T_CONSTANT_ENCAPSED_STRING, '"b"', 3],
            ';',
        ];

        $lexer = $this->getLexer();
        $lexer->startLexing($code);
        $this->assertSame($expectedTokens, $lexer->getTokens());
    }
}
