<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\NameInformation;

use function array_pop;
use function array_push;
use function current;
use function end;
use function key;
use function next;
use function preg_match;
use function reset;
use function strlen;
use function strpos;
use function substr;
use function trim;

class DocBlockScanner implements ScannerInterface
{
    /**
     * @var bool
     */
    protected $isScanned = false;

    /**
     * @var string
     */
    protected $docComment;

    /**
     * @var NameInformation
     */
    protected $nameInformation;

    /**
     * @var AnnotationManager
     */
    protected $annotationManager;

    /**
     * @var string
     */
    protected $shortDescription;

    /**
     * @var string
     */
    protected $longDescription = '';

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @var array
     */
    protected $annotations = [];

    /**
     * @param  string $docComment
     * @param null|NameInformation $nameInformation
     */
    public function __construct($docComment, NameInformation $nameInformation = null)
    {
        $this->docComment      = $docComment;
        $this->nameInformation = $nameInformation;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        $this->scan();

        return $this->shortDescription;
    }

    /**
     * @return string
     */
    public function getLongDescription()
    {
        $this->scan();

        return $this->longDescription;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $this->scan();

        return $this->tags;
    }

    /**
     * @return array
     */
    public function getAnnotations()
    {
        $this->scan();

        return $this->annotations;
    }

    /**
     * @return void
     */
    protected function scan()
    {
        if ($this->isScanned) {
            return;
        }

        $mode = 1;

        $tokens   = $this->tokenize();
        $tagIndex = null;
        reset($tokens);

        SCANNER_TOP:
        $token = current($tokens);

        switch ($token[0]) {
            case 'DOCBLOCK_NEWLINE':
                if ($this->shortDescription != '' && $tagIndex === null) {
                    $mode = 2;
                } else {
                    $this->longDescription .= $token[1];
                }
                goto SCANNER_CONTINUE;
                //goto no break needed

            case 'DOCBLOCK_WHITESPACE':
            case 'DOCBLOCK_TEXT':
                if ($tagIndex !== null) {
                    $this->tags[$tagIndex]['value'] .= $this->tags[$tagIndex]['value'] == ''
                        ? $token[1]
                        : ' ' . $token[1];
                    goto SCANNER_CONTINUE;
                } elseif ($mode <= 2) {
                    if ($mode == 1) {
                        $this->shortDescription .= $token[1];
                    } else {
                        $this->longDescription .= $token[1];
                    }
                    goto SCANNER_CONTINUE;
                }
                //gotos no break needed
            case 'DOCBLOCK_TAG':
                array_push($this->tags, [
                    'name'  => $token[1],
                    'value' => '',
                ]);
                end($this->tags);
                $tagIndex = key($this->tags);
                $mode     = 3;
                goto SCANNER_CONTINUE;
                //goto no break needed

            case 'DOCBLOCK_COMMENTEND':
                goto SCANNER_END;
        }

        SCANNER_CONTINUE:
        if (next($tokens) === false) {
            goto SCANNER_END;
        }
        goto SCANNER_TOP;

        SCANNER_END:

        $this->shortDescription = trim($this->shortDescription);
        $this->longDescription  = trim($this->longDescription);
        $this->isScanned        = true;
    }

    /**
     * @return array
     */
    protected function tokenize()
    {
        static $CONTEXT_INSIDE_DOCBLOCK = 0x01;
        static $CONTEXT_INSIDE_ASTERISK = 0x02;

        $context     = 0x00;
        $stream      = $this->docComment;
        $streamIndex = null;
        $tokens      = [];
        $tokenIndex  = null;
        $currentChar = null;
        $currentWord = null;
        $currentLine = null;

        $MACRO_STREAM_ADVANCE_CHAR = function ($positionsForward = 1) use (
            &$stream,
            &$streamIndex,
            &$currentChar,
            &$currentWord,
            &$currentLine
        ) {
            $positionsForward = $positionsForward > 0 ? $positionsForward : 1;
            $streamIndex      = $streamIndex === null ? 0 : $streamIndex + $positionsForward;
            if (! isset($stream[$streamIndex])) {
                $currentChar = false;

                return false;
            }
            $currentChar = $stream[$streamIndex];
            $matches     = [];
            $currentLine = preg_match('#(.*?)\r?\n#', $stream, $matches, null, $streamIndex) === 1
                ? $matches[1]
                : substr($stream, $streamIndex);
            if ($currentChar === ' ') {
                $currentWord = preg_match('#( +)#', $currentLine, $matches) === 1 ? $matches[1] : $currentLine;
            } else {
                $currentWord = ($matches = strpos($currentLine, ' ')) !== false
                    ? substr($currentLine, 0, $matches)
                    : $currentLine;
            }

            return $currentChar;
        };
        $MACRO_STREAM_ADVANCE_WORD       = function () use (&$currentWord, &$MACRO_STREAM_ADVANCE_CHAR) {
            return $MACRO_STREAM_ADVANCE_CHAR(strlen($currentWord));
        };
        $MACRO_STREAM_ADVANCE_LINE       = function () use (&$currentLine, &$MACRO_STREAM_ADVANCE_CHAR) {
            return $MACRO_STREAM_ADVANCE_CHAR(strlen($currentLine));
        };
        $MACRO_TOKEN_ADVANCE             = function () use (&$tokenIndex, &$tokens) {
            $tokenIndex          = $tokenIndex === null ? 0 : $tokenIndex + 1;
            $tokens[$tokenIndex] = ['DOCBLOCK_UNKNOWN', ''];
        };
        $MACRO_TOKEN_SET_TYPE            = function ($type) use (&$tokenIndex, &$tokens) {
            $tokens[$tokenIndex][0] = $type;
        };
        $MACRO_TOKEN_APPEND_CHAR         = function () use (&$currentChar, &$tokens, &$tokenIndex) {
            $tokens[$tokenIndex][1] .= $currentChar;
        };
        $MACRO_TOKEN_APPEND_WORD         = function () use (&$currentWord, &$tokens, &$tokenIndex) {
            $tokens[$tokenIndex][1] .= $currentWord;
        };
        $MACRO_TOKEN_APPEND_WORD_PARTIAL = function ($length) use (&$currentWord, &$tokens, &$tokenIndex) {
            $tokens[$tokenIndex][1] .= substr($currentWord, 0, $length);
        };
        $MACRO_TOKEN_APPEND_LINE         = function () use (&$currentLine, &$tokens, &$tokenIndex) {
            $tokens[$tokenIndex][1] .= $currentLine;
        };

        $MACRO_STREAM_ADVANCE_CHAR();
        $MACRO_TOKEN_ADVANCE();

        TOKENIZER_TOP:

        if ($context === 0x00 && $currentChar === '/' && $currentWord === '/**') {
            $MACRO_TOKEN_SET_TYPE('DOCBLOCK_COMMENTSTART');
            $MACRO_TOKEN_APPEND_WORD();
            $MACRO_TOKEN_ADVANCE();
            $context |= $CONTEXT_INSIDE_DOCBLOCK;
            $context |= $CONTEXT_INSIDE_ASTERISK;
            if ($MACRO_STREAM_ADVANCE_WORD() === false) {
                goto TOKENIZER_END;
            }
            goto TOKENIZER_TOP;
        }

        if ($context & $CONTEXT_INSIDE_DOCBLOCK && $currentWord === '*/') {
            $MACRO_TOKEN_SET_TYPE('DOCBLOCK_COMMENTEND');
            $MACRO_TOKEN_APPEND_WORD();
            $MACRO_TOKEN_ADVANCE();
            $context &= ~$CONTEXT_INSIDE_DOCBLOCK;
            if ($MACRO_STREAM_ADVANCE_WORD() === false) {
                goto TOKENIZER_END;
            }
            goto TOKENIZER_TOP;
        }

        if ($currentChar === ' ' || $currentChar === "\t") {
            $MACRO_TOKEN_SET_TYPE(
                $context & $CONTEXT_INSIDE_ASTERISK
                ? 'DOCBLOCK_WHITESPACE'
                : 'DOCBLOCK_WHITESPACE_INDENT'
            );
            $MACRO_TOKEN_APPEND_WORD();
            $MACRO_TOKEN_ADVANCE();
            if ($MACRO_STREAM_ADVANCE_WORD() === false) {
                goto TOKENIZER_END;
            }
            goto TOKENIZER_TOP;
        }

        if ($currentChar === '*') {
            if (($context & $CONTEXT_INSIDE_DOCBLOCK) && ($context & $CONTEXT_INSIDE_ASTERISK)) {
                $MACRO_TOKEN_SET_TYPE('DOCBLOCK_TEXT');
            } else {
                $MACRO_TOKEN_SET_TYPE('DOCBLOCK_ASTERISK');
                $context |= $CONTEXT_INSIDE_ASTERISK;
            }
            $MACRO_TOKEN_APPEND_CHAR();
            $MACRO_TOKEN_ADVANCE();
            if ($MACRO_STREAM_ADVANCE_CHAR() === false) {
                goto TOKENIZER_END;
            }
            goto TOKENIZER_TOP;
        }

        if ($currentChar === '@') {
            $MACRO_TOKEN_SET_TYPE('DOCBLOCK_TAG');
            $MACRO_TOKEN_APPEND_WORD();
            $MACRO_TOKEN_ADVANCE();
            if ($MACRO_STREAM_ADVANCE_WORD() === false) {
                goto TOKENIZER_END;
            }
            goto TOKENIZER_TOP;
        }

        if ($currentChar === "\n") {
            $MACRO_TOKEN_SET_TYPE('DOCBLOCK_NEWLINE');
            $MACRO_TOKEN_APPEND_CHAR();
            $MACRO_TOKEN_ADVANCE();
            $context &= ~$CONTEXT_INSIDE_ASTERISK;
            if ($MACRO_STREAM_ADVANCE_CHAR() === false) {
                goto TOKENIZER_END;
            }
            goto TOKENIZER_TOP;
        }

        $MACRO_TOKEN_SET_TYPE('DOCBLOCK_TEXT');
        $MACRO_TOKEN_APPEND_LINE();
        $MACRO_TOKEN_ADVANCE();
        if ($MACRO_STREAM_ADVANCE_LINE() === false) {
            goto TOKENIZER_END;
        }
        goto TOKENIZER_TOP;

        TOKENIZER_END:

        array_pop($tokens);

        return $tokens;
    }
}
