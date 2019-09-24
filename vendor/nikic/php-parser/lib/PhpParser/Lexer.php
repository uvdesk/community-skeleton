<?php declare(strict_types=1);

namespace PhpParser;

use PhpParser\Parser\Tokens;

class Lexer
{
    protected $code;
    protected $tokens;
    protected $pos;
    protected $line;
    protected $filePos;
    protected $prevCloseTagHasNewline;

    protected $tokenMap;
    protected $dropTokens;

    private $attributeStartLineUsed;
    private $attributeEndLineUsed;
    private $attributeStartTokenPosUsed;
    private $attributeEndTokenPosUsed;
    private $attributeStartFilePosUsed;
    private $attributeEndFilePosUsed;
    private $attributeCommentsUsed;

    /**
     * Creates a Lexer.
     *
     * @param array $options Options array. Currently only the 'usedAttributes' option is supported,
     *                       which is an array of attributes to add to the AST nodes. Possible
     *                       attributes are: 'comments', 'startLine', 'endLine', 'startTokenPos',
     *                       'endTokenPos', 'startFilePos', 'endFilePos'. The option defaults to the
     *                       first three. For more info see getNextToken() docs.
     */
    public function __construct(array $options = []) {
        // map from internal tokens to PhpParser tokens
        $this->tokenMap = $this->createTokenMap();

        // Compatibility define for PHP < 7.4
        if (!defined('T_BAD_CHARACTER')) {
            \define('T_BAD_CHARACTER', -1);
        }

        // map of tokens to drop while lexing (the map is only used for isset lookup,
        // that's why the value is simply set to 1; the value is never actually used.)
        $this->dropTokens = array_fill_keys(
            [\T_WHITESPACE, \T_OPEN_TAG, \T_COMMENT, \T_DOC_COMMENT, \T_BAD_CHARACTER], 1
        );

        $defaultAttributes = ['comments', 'startLine', 'endLine'];
        $usedAttributes = array_fill_keys($options['usedAttributes'] ?? $defaultAttributes, true);

        // Create individual boolean properties to make these checks faster.
        $this->attributeStartLineUsed = isset($usedAttributes['startLine']);
        $this->attributeEndLineUsed = isset($usedAttributes['endLine']);
        $this->attributeStartTokenPosUsed = isset($usedAttributes['startTokenPos']);
        $this->attributeEndTokenPosUsed = isset($usedAttributes['endTokenPos']);
        $this->attributeStartFilePosUsed = isset($usedAttributes['startFilePos']);
        $this->attributeEndFilePosUsed = isset($usedAttributes['endFilePos']);
        $this->attributeCommentsUsed = isset($usedAttributes['comments']);
    }

    /**
     * Initializes the lexer for lexing the provided source code.
     *
     * This function does not throw if lexing errors occur. Instead, errors may be retrieved using
     * the getErrors() method.
     *
     * @param string $code The source code to lex
     * @param ErrorHandler|null $errorHandler Error handler to use for lexing errors. Defaults to
     *                                        ErrorHandler\Throwing
     */
    public function startLexing(string $code, ErrorHandler $errorHandler = null) {
        if (null === $errorHandler) {
            $errorHandler = new ErrorHandler\Throwing();
        }

        $this->code = $code; // keep the code around for __halt_compiler() handling
        $this->pos  = -1;
        $this->line =  1;
        $this->filePos = 0;

        // If inline HTML occurs without preceding code, treat it as if it had a leading newline.
        // This ensures proper composability, because having a newline is the "safe" assumption.
        $this->prevCloseTagHasNewline = true;

        $scream = ini_set('xdebug.scream', '0');

        error_clear_last();
        $this->tokens = @token_get_all($code);
        $this->handleErrors($errorHandler);

        if (false !== $scream) {
            ini_set('xdebug.scream', $scream);
        }
    }

    private function handleInvalidCharacterRange($start, $end, $line, ErrorHandler $errorHandler) {
        $tokens = [];
        for ($i = $start; $i < $end; $i++) {
            $chr = $this->code[$i];
            if ($chr === "\0") {
                // PHP cuts error message after null byte, so need special case
                $errorMsg = 'Unexpected null byte';
            } else {
                $errorMsg = sprintf(
                    'Unexpected character "%s" (ASCII %d)', $chr, ord($chr)
                );
            }

            $tokens[] = [\T_BAD_CHARACTER, $chr, $line];
            $errorHandler->handleError(new Error($errorMsg, [
                'startLine' => $line,
                'endLine' => $line,
                'startFilePos' => $i,
                'endFilePos' => $i,
            ]));
        }
        return $tokens;
    }

    /**
     * Check whether comment token is unterminated.
     *
     * @return bool
     */
    private function isUnterminatedComment($token) : bool {
        return ($token[0] === \T_COMMENT || $token[0] === \T_DOC_COMMENT)
            && substr($token[1], 0, 2) === '/*'
            && substr($token[1], -2) !== '*/';
    }

    /**
     * Check whether an error *may* have occurred during tokenization.
     *
     * @return bool
     */
    private function errorMayHaveOccurred() : bool {
        if (defined('HHVM_VERSION')) {
            // In HHVM token_get_all() does not throw warnings, so we need to conservatively
            // assume that an error occurred
            return true;
        }

        return null !== error_get_last();
    }

    protected function handleErrors(ErrorHandler $errorHandler) {
        if (!$this->errorMayHaveOccurred()) {
            return;
        }

        // PHP's error handling for token_get_all() is rather bad, so if we want detailed
        // error information we need to compute it ourselves. Invalid character errors are
        // detected by finding "gaps" in the token array. Unterminated comments are detected
        // by checking if a trailing comment has a "*/" at the end.

        $filePos = 0;
        $line = 1;
        $numTokens = \count($this->tokens);
        for ($i = 0; $i < $numTokens; $i++) {
            $token = $this->tokens[$i];

            // Since PHP 7.4 invalid characters are represented by a T_BAD_CHARACTER token.
            // In this case we only need to emit an error.
            if ($token[0] === \T_BAD_CHARACTER) {
                $this->handleInvalidCharacterRange($filePos, $filePos + 1, $line, $errorHandler);
            }

            $tokenValue = \is_string($token) ? $token : $token[1];
            $tokenLen = \strlen($tokenValue);

            if (substr($this->code, $filePos, $tokenLen) !== $tokenValue) {
                // Something is missing, must be an invalid character
                $nextFilePos = strpos($this->code, $tokenValue, $filePos);
                $badCharTokens = $this->handleInvalidCharacterRange(
                    $filePos, $nextFilePos, $line, $errorHandler);
                $filePos = (int) $nextFilePos;

                array_splice($this->tokens, $i, 0, $badCharTokens);
                $numTokens += \count($badCharTokens);
                $i += \count($badCharTokens);
            }

            $filePos += $tokenLen;
            $line += substr_count($tokenValue, "\n");
        }

        if ($filePos !== \strlen($this->code)) {
            if (substr($this->code, $filePos, 2) === '/*') {
                // Unlike PHP, HHVM will drop unterminated comments entirely
                $comment = substr($this->code, $filePos);
                $errorHandler->handleError(new Error('Unterminated comment', [
                    'startLine' => $line,
                    'endLine' => $line + substr_count($comment, "\n"),
                    'startFilePos' => $filePos,
                    'endFilePos' => $filePos + \strlen($comment),
                ]));

                // Emulate the PHP behavior
                $isDocComment = isset($comment[3]) && $comment[3] === '*';
                $this->tokens[] = [$isDocComment ? \T_DOC_COMMENT : \T_COMMENT, $comment, $line];
            } else {
                // Invalid characters at the end of the input
                $badCharTokens = $this->handleInvalidCharacterRange(
                    $filePos, \strlen($this->code), $line, $errorHandler);
                $this->tokens = array_merge($this->tokens, $badCharTokens);
            }
            return;
        }

        if (count($this->tokens) > 0) {
            // Check for unterminated comment
            $lastToken = $this->tokens[count($this->tokens) - 1];
            if ($this->isUnterminatedComment($lastToken)) {
                $errorHandler->handleError(new Error('Unterminated comment', [
                    'startLine' => $line - substr_count($lastToken[1], "\n"),
                    'endLine' => $line,
                    'startFilePos' => $filePos - \strlen($lastToken[1]),
                    'endFilePos' => $filePos,
                ]));
            }
        }
    }

    /**
     * Fetches the next token.
     *
     * The available attributes are determined by the 'usedAttributes' option, which can
     * be specified in the constructor. The following attributes are supported:
     *
     *  * 'comments'      => Array of PhpParser\Comment or PhpParser\Comment\Doc instances,
     *                       representing all comments that occurred between the previous
     *                       non-discarded token and the current one.
     *  * 'startLine'     => Line in which the node starts.
     *  * 'endLine'       => Line in which the node ends.
     *  * 'startTokenPos' => Offset into the token array of the first token in the node.
     *  * 'endTokenPos'   => Offset into the token array of the last token in the node.
     *  * 'startFilePos'  => Offset into the code string of the first character that is part of the node.
     *  * 'endFilePos'    => Offset into the code string of the last character that is part of the node.
     *
     * @param mixed $value           Variable to store token content in
     * @param mixed $startAttributes Variable to store start attributes in
     * @param mixed $endAttributes   Variable to store end attributes in
     *
     * @return int Token id
     */
    public function getNextToken(&$value = null, &$startAttributes = null, &$endAttributes = null) : int {
        $startAttributes = [];
        $endAttributes   = [];

        while (1) {
            if (isset($this->tokens[++$this->pos])) {
                $token = $this->tokens[$this->pos];
            } else {
                // EOF token with ID 0
                $token = "\0";
            }

            if ($this->attributeStartLineUsed) {
                $startAttributes['startLine'] = $this->line;
            }
            if ($this->attributeStartTokenPosUsed) {
                $startAttributes['startTokenPos'] = $this->pos;
            }
            if ($this->attributeStartFilePosUsed) {
                $startAttributes['startFilePos'] = $this->filePos;
            }

            if (\is_string($token)) {
                $value = $token;
                if (isset($token[1])) {
                    // bug in token_get_all
                    $this->filePos += 2;
                    $id = ord('"');
                } else {
                    $this->filePos += 1;
                    $id = ord($token);
                }
            } elseif (!isset($this->dropTokens[$token[0]])) {
                $value = $token[1];
                $id = $this->tokenMap[$token[0]];
                if (\T_CLOSE_TAG === $token[0]) {
                    $this->prevCloseTagHasNewline = false !== strpos($token[1], "\n");
                } elseif (\T_INLINE_HTML === $token[0]) {
                    $startAttributes['hasLeadingNewline'] = $this->prevCloseTagHasNewline;
                }

                $this->line += substr_count($value, "\n");
                $this->filePos += \strlen($value);
            } else {
                if (\T_COMMENT === $token[0] || \T_DOC_COMMENT === $token[0]) {
                    if ($this->attributeCommentsUsed) {
                        $comment = \T_DOC_COMMENT === $token[0]
                            ? new Comment\Doc($token[1], $this->line, $this->filePos, $this->pos)
                            : new Comment($token[1], $this->line, $this->filePos, $this->pos);
                        $startAttributes['comments'][] = $comment;
                    }
                }

                $this->line += substr_count($token[1], "\n");
                $this->filePos += \strlen($token[1]);
                continue;
            }

            if ($this->attributeEndLineUsed) {
                $endAttributes['endLine'] = $this->line;
            }
            if ($this->attributeEndTokenPosUsed) {
                $endAttributes['endTokenPos'] = $this->pos;
            }
            if ($this->attributeEndFilePosUsed) {
                $endAttributes['endFilePos'] = $this->filePos - 1;
            }

            return $id;
        }

        throw new \RuntimeException('Reached end of lexer loop');
    }

    /**
     * Returns the token array for current code.
     *
     * The token array is in the same format as provided by the
     * token_get_all() function and does not discard tokens (i.e.
     * whitespace and comments are included). The token position
     * attributes are against this token array.
     *
     * @return array Array of tokens in token_get_all() format
     */
    public function getTokens() : array {
        return $this->tokens;
    }

    /**
     * Handles __halt_compiler() by returning the text after it.
     *
     * @return string Remaining text
     */
    public function handleHaltCompiler() : string {
        // text after T_HALT_COMPILER, still including ();
        $textAfter = substr($this->code, $this->filePos);

        // ensure that it is followed by ();
        // this simplifies the situation, by not allowing any comments
        // in between of the tokens.
        if (!preg_match('~^\s*\(\s*\)\s*(?:;|\?>\r?\n?)~', $textAfter, $matches)) {
            throw new Error('__HALT_COMPILER must be followed by "();"');
        }

        // prevent the lexer from returning any further tokens
        $this->pos = count($this->tokens);

        // return with (); removed
        return substr($textAfter, strlen($matches[0]));
    }

    /**
     * Creates the token map.
     *
     * The token map maps the PHP internal token identifiers
     * to the identifiers used by the Parser. Additionally it
     * maps T_OPEN_TAG_WITH_ECHO to T_ECHO and T_CLOSE_TAG to ';'.
     *
     * @return array The token map
     */
    protected function createTokenMap() : array {
        $tokenMap = [];

        // 256 is the minimum possible token number, as everything below
        // it is an ASCII value
        for ($i = 256; $i < 1000; ++$i) {
            if (\T_DOUBLE_COLON === $i) {
                // T_DOUBLE_COLON is equivalent to T_PAAMAYIM_NEKUDOTAYIM
                $tokenMap[$i] = Tokens::T_PAAMAYIM_NEKUDOTAYIM;
            } elseif(\T_OPEN_TAG_WITH_ECHO === $i) {
                // T_OPEN_TAG_WITH_ECHO with dropped T_OPEN_TAG results in T_ECHO
                $tokenMap[$i] = Tokens::T_ECHO;
            } elseif(\T_CLOSE_TAG === $i) {
                // T_CLOSE_TAG is equivalent to ';'
                $tokenMap[$i] = ord(';');
            } elseif ('UNKNOWN' !== $name = token_name($i)) {
                if ('T_HASHBANG' === $name) {
                    // HHVM uses a special token for #! hashbang lines
                    $tokenMap[$i] = Tokens::T_INLINE_HTML;
                } elseif (defined($name = Tokens::class . '::' . $name)) {
                    // Other tokens can be mapped directly
                    $tokenMap[$i] = constant($name);
                }
            }
        }

        // HHVM uses a special token for numbers that overflow to double
        if (defined('T_ONUMBER')) {
            $tokenMap[\T_ONUMBER] = Tokens::T_DNUMBER;
        }
        // HHVM also has a separate token for the __COMPILER_HALT_OFFSET__ constant
        if (defined('T_COMPILER_HALT_OFFSET')) {
            $tokenMap[\T_COMPILER_HALT_OFFSET] = Tokens::T_STRING;
        }

        return $tokenMap;
    }
}
