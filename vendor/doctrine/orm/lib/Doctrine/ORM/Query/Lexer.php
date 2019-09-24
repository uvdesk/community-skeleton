<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Query;

use Doctrine\Common\Lexer\AbstractLexer;

/**
 * Scans a DQL query for tokens.
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Janne Vanhala <jpvanhal@cc.hut.fi>
 * @author Roman Borschel <roman@code-factory.org>
 * @since 2.0
 */
class Lexer extends AbstractLexer
{
    // All tokens that are not valid identifiers must be < 100
    const T_NONE                 = 1;
    const T_INTEGER              = 2;
    const T_STRING               = 3;
    const T_INPUT_PARAMETER      = 4;
    const T_FLOAT                = 5;
    const T_CLOSE_PARENTHESIS    = 6;
    const T_OPEN_PARENTHESIS     = 7;
    const T_COMMA                = 8;
    const T_DIVIDE               = 9;
    const T_DOT                  = 10;
    const T_EQUALS               = 11;
    const T_GREATER_THAN         = 12;
    const T_LOWER_THAN           = 13;
    const T_MINUS                = 14;
    const T_MULTIPLY             = 15;
    const T_NEGATE               = 16;
    const T_PLUS                 = 17;
    const T_OPEN_CURLY_BRACE     = 18;
    const T_CLOSE_CURLY_BRACE    = 19;

    // All tokens that are identifiers or keywords that could be considered as identifiers should be >= 100
    const T_ALIASED_NAME         = 100;
    const T_FULLY_QUALIFIED_NAME = 101;
    const T_IDENTIFIER           = 102;

    // All keyword tokens should be >= 200
    const T_ALL                  = 200;
    const T_AND                  = 201;
    const T_ANY                  = 202;
    const T_AS                   = 203;
    const T_ASC                  = 204;
    const T_AVG                  = 205;
    const T_BETWEEN              = 206;
    const T_BOTH                 = 207;
    const T_BY                   = 208;
    const T_CASE                 = 209;
    const T_COALESCE             = 210;
    const T_COUNT                = 211;
    const T_DELETE               = 212;
    const T_DESC                 = 213;
    const T_DISTINCT             = 214;
    const T_ELSE                 = 215;
    const T_EMPTY                = 216;
    const T_END                  = 217;
    const T_ESCAPE               = 218;
    const T_EXISTS               = 219;
    const T_FALSE                = 220;
    const T_FROM                 = 221;
    const T_GROUP                = 222;
    const T_HAVING               = 223;
    const T_HIDDEN               = 224;
    const T_IN                   = 225;
    const T_INDEX                = 226;
    const T_INNER                = 227;
    const T_INSTANCE             = 228;
    const T_IS                   = 229;
    const T_JOIN                 = 230;
    const T_LEADING              = 231;
    const T_LEFT                 = 232;
    const T_LIKE                 = 233;
    const T_MAX                  = 234;
    const T_MEMBER               = 235;
    const T_MIN                  = 236;
    const T_NEW                  = 237;
    const T_NOT                  = 238;
    const T_NULL                 = 239;
    const T_NULLIF               = 240;
    const T_OF                   = 241;
    const T_OR                   = 242;
    const T_ORDER                = 243;
    const T_OUTER                = 244;
    const T_PARTIAL              = 245;
    const T_SELECT               = 246;
    const T_SET                  = 247;
    const T_SOME                 = 248;
    const T_SUM                  = 249;
    const T_THEN                 = 250;
    const T_TRAILING             = 251;
    const T_TRUE                 = 252;
    const T_UPDATE               = 253;
    const T_WHEN                 = 254;
    const T_WHERE                = 255;
    const T_WITH                 = 256;

    /**
     * Creates a new query scanner object.
     *
     * @param string $input A query string.
     */
    public function __construct($input)
    {
        $this->setInput($input);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCatchablePatterns()
    {
        return [
            '[a-z_][a-z0-9_]*\:[a-z_][a-z0-9_]*(?:\\\[a-z_][a-z0-9_]*)*', // aliased name
            '[a-z_\\\][a-z0-9_]*(?:\\\[a-z_][a-z0-9_]*)*', // identifier or qualified name
            '(?:[0-9]+(?:[\.][0-9]+)*)(?:e[+-]?[0-9]+)?', // numbers
            "'(?:[^']|'')*'", // quoted strings
            '\?[0-9]*|:[a-z_][a-z0-9_]*' // parameters
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getNonCatchablePatterns()
    {
        return ['\s+', '(.)'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getType(&$value)
    {
        $type = self::T_NONE;

        switch (true) {
            // Recognize numeric values
            case (is_numeric($value)):
                if (strpos($value, '.') !== false || stripos($value, 'e') !== false) {
                    return self::T_FLOAT;
                }

                return self::T_INTEGER;

            // Recognize quoted strings
            case ($value[0] === "'"):
                $value = str_replace("''", "'", substr($value, 1, strlen($value) - 2));

                return self::T_STRING;

            // Recognize identifiers, aliased or qualified names
            case (ctype_alpha($value[0]) || $value[0] === '_' || $value[0] === '\\'):
                $name = 'Doctrine\ORM\Query\Lexer::T_' . strtoupper($value);

                if (defined($name)) {
                    $type = constant($name);

                    if ($type > 100) {
                        return $type;
                    }
                }

                if (strpos($value, ':') !== false) {
                    return self::T_ALIASED_NAME;
                }

                if (strpos($value, '\\') !== false) {
                    return self::T_FULLY_QUALIFIED_NAME;
                }

                return self::T_IDENTIFIER;

            // Recognize input parameters
            case ($value[0] === '?' || $value[0] === ':'):
                return self::T_INPUT_PARAMETER;

            // Recognize symbols
            case ($value === '.'): return self::T_DOT;
            case ($value === ','): return self::T_COMMA;
            case ($value === '('): return self::T_OPEN_PARENTHESIS;
            case ($value === ')'): return self::T_CLOSE_PARENTHESIS;
            case ($value === '='): return self::T_EQUALS;
            case ($value === '>'): return self::T_GREATER_THAN;
            case ($value === '<'): return self::T_LOWER_THAN;
            case ($value === '+'): return self::T_PLUS;
            case ($value === '-'): return self::T_MINUS;
            case ($value === '*'): return self::T_MULTIPLY;
            case ($value === '/'): return self::T_DIVIDE;
            case ($value === '!'): return self::T_NEGATE;
            case ($value === '{'): return self::T_OPEN_CURLY_BRACE;
            case ($value === '}'): return self::T_CLOSE_CURLY_BRACE;

            // Default
            default:
                // Do nothing
        }

        return $type;
    }
}
