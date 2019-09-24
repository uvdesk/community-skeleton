<?php

namespace Doctrine\Bundle\DoctrineBundle\Twig;

use SqlFormatter;
use Symfony\Component\VarDumper\Cloner\Data;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * This class contains the needed functions in order to do the query highlighting
 */
class DoctrineExtension extends AbstractExtension
{
    /**
     * Number of maximum characters that one single line can hold in the interface
     *
     * @var int
     */
    private $maxCharWidth = 100;

    /**
     * Define our functions
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('doctrine_minify_query', [$this, 'minifyQuery'], ['deprecated' => true]),
            new TwigFilter('doctrine_pretty_query', [$this, 'formatQuery'], ['is_safe' => ['html']]),
            new TwigFilter('doctrine_replace_query_parameters', [$this, 'replaceQueryParameters']),
        ];
    }

    /**
     * Get the possible combinations of elements from the given array
     *
     * @param array $elements
     * @param int   $combinationsLevel
     *
     * @return array
     */
    private function getPossibleCombinations(array $elements, $combinationsLevel)
    {
        $baseCount = count($elements);
        $result    = [];

        if ($combinationsLevel === 1) {
            foreach ($elements as $element) {
                $result[] = [$element];
            }

            return $result;
        }

        $nextLevelElements = $this->getPossibleCombinations($elements, $combinationsLevel - 1);

        foreach ($nextLevelElements as $nextLevelElement) {
            $lastElement = $nextLevelElement[$combinationsLevel - 2];
            $found       = false;

            foreach ($elements as $key => $element) {
                if ($element === $lastElement) {
                    $found = true;
                    continue;
                }

                if ($found !== true || $key >= $baseCount) {
                    continue;
                }

                $tmp              = $nextLevelElement;
                $newCombination   = array_slice($tmp, 0);
                $newCombination[] = $element;
                $result[]         = array_slice($newCombination, 0);
            }
        }

        return $result;
    }

    /**
     * Shrink the values of parameters from a combination
     *
     * @param array $parameters
     * @param array $combination
     *
     * @return string
     */
    private function shrinkParameters(array $parameters, array $combination)
    {
        array_shift($parameters);
        $result = '';

        $maxLength  = $this->maxCharWidth;
        $maxLength -= count($parameters) * 5;
        $maxLength /= count($parameters);

        foreach ($parameters as $key => $value) {
            $isLarger = false;

            if (strlen($value) > $maxLength) {
                $value = wordwrap($value, $maxLength, "\n", true);
                $value = explode("\n", $value);
                $value = $value[0];

                $isLarger = true;
            }
            $value = self::escapeFunction($value);

            if (! is_numeric($value)) {
                $value = substr($value, 1, -1);
            }

            if ($isLarger) {
                $value .= ' [...]';
            }

            $result .= ' ' . $combination[$key] . ' ' . $value;
        }

        return trim($result);
    }

    /**
     * Attempt to compose the best scenario minified query so that a user could find it without expanding it
     *
     * @param string $query
     * @param array  $keywords
     * @param int    $required
     *
     * @return string
     */
    private function composeMiniQuery($query, array $keywords, $required)
    {
        // Extract the mandatory keywords and consider the rest as optional keywords
        $mandatoryKeywords = array_splice($keywords, 0, $required);

        $combinations      = [];
        $combinationsCount = count($keywords);

        // Compute all the possible combinations of keywords to match the query for
        while ($combinationsCount > 0) {
            $combinations = array_merge($combinations, $this->getPossibleCombinations($keywords, $combinationsCount));
            $combinationsCount--;
        }

        // Try and match the best case query pattern
        foreach ($combinations as $combination) {
            $combination = array_merge($mandatoryKeywords, $combination);

            $regexp = implode('(.*) ', $combination) . ' (.*)';
            $regexp = '/^' . $regexp . '/is';

            if (preg_match($regexp, $query, $matches)) {
                return $this->shrinkParameters($matches, $combination);
            }
        }

        // Try and match the simplest query form that contains only the mandatory keywords
        $regexp = implode(' (.*)', $mandatoryKeywords) . ' (.*)';
        $regexp = '/^' . $regexp . '/is';

        if (preg_match($regexp, $query, $matches)) {
            return $this->shrinkParameters($matches, $mandatoryKeywords);
        }

        // Fallback in case we didn't managed to find any good match (can we actually have that happen?!)
        return substr($query, 0, $this->maxCharWidth);
    }

    /**
     * Minify the query
     *
     * @param string $query
     *
     * @return string
     */
    public function minifyQuery($query)
    {
        $result   = '';
        $keywords = [];
        $required = 1;

        // Check if we can match the query against any of the major types
        switch (true) {
            case stripos($query, 'SELECT') !== false:
                $keywords = ['SELECT', 'FROM', 'WHERE', 'HAVING', 'ORDER BY', 'LIMIT'];
                $required = 2;
                break;

            case stripos($query, 'DELETE') !== false:
                $keywords = ['DELETE', 'FROM', 'WHERE', 'ORDER BY', 'LIMIT'];
                $required = 2;
                break;

            case stripos($query, 'UPDATE') !== false:
                $keywords = ['UPDATE', 'SET', 'WHERE', 'ORDER BY', 'LIMIT'];
                $required = 2;
                break;

            case stripos($query, 'INSERT') !== false:
                $keywords = ['INSERT', 'INTO', 'VALUE', 'VALUES'];
                $required = 2;
                break;

            // If there's no match so far just truncate it to the maximum allowed by the interface
            default:
                $result = substr($query, 0, $this->maxCharWidth);
        }

        // If we had a match then we should minify it
        if ($result === '') {
            $result = $this->composeMiniQuery($query, $keywords, $required);
        }

        return $result;
    }

    /**
     * Escape parameters of a SQL query
     * DON'T USE THIS FUNCTION OUTSIDE ITS INTENDED SCOPE
     *
     * @internal
     *
     * @param mixed $parameter
     *
     * @return string
     */
    public static function escapeFunction($parameter)
    {
        $result = $parameter;

        switch (true) {
            // Check if result is non-unicode string using PCRE_UTF8 modifier
            case is_string($result) && ! preg_match('//u', $result):
                $result = '0x' . strtoupper(bin2hex($result));
                break;

            case is_string($result):
                $result = "'" . addslashes($result) . "'";
                break;

            case is_array($result):
                foreach ($result as &$value) {
                    $value = static::escapeFunction($value);
                }

                $result = implode(', ', $result);
                break;

            case is_object($result):
                $result = addslashes((string) $result);
                break;

            case $result === null:
                $result = 'NULL';
                break;

            case is_bool($result):
                $result = $result ? '1' : '0';
                break;
        }

        return $result;
    }

    /**
     * Return a query with the parameters replaced
     *
     * @param string     $query
     * @param array|Data $parameters
     *
     * @return string
     */
    public function replaceQueryParameters($query, $parameters)
    {
        if ($parameters instanceof Data) {
            $parameters = $parameters->getValue(true);
        }

        $i = 0;

        if (! array_key_exists(0, $parameters) && array_key_exists(1, $parameters)) {
            $i = 1;
        }

        return preg_replace_callback(
            '/\?|((?<!:):[a-z0-9_]+)/i',
            static function ($matches) use ($parameters, &$i) {
                $key = substr($matches[0], 1);

                if (! array_key_exists($i, $parameters) && ($key === false || ! array_key_exists($key, $parameters))) {
                    return $matches[0];
                }

                $value  = array_key_exists($i, $parameters) ? $parameters[$i] : $parameters[$key];
                $result = DoctrineExtension::escapeFunction($value);
                $i++;

                return $result;
            },
            $query
        );
    }

    /**
     * Formats and/or highlights the given SQL statement.
     *
     * @param  string $sql
     * @param  bool   $highlightOnly If true the query is not formatted, just highlighted
     *
     * @return string
     */
    public function formatQuery($sql, $highlightOnly = false)
    {
        SqlFormatter::$pre_attributes            = 'class="highlight highlight-sql"';
        SqlFormatter::$quote_attributes          = 'class="string"';
        SqlFormatter::$backtick_quote_attributes = 'class="string"';
        SqlFormatter::$reserved_attributes       = 'class="keyword"';
        SqlFormatter::$boundary_attributes       = 'class="symbol"';
        SqlFormatter::$number_attributes         = 'class="number"';
        SqlFormatter::$word_attributes           = 'class="word"';
        SqlFormatter::$error_attributes          = 'class="error"';
        SqlFormatter::$comment_attributes        = 'class="comment"';
        SqlFormatter::$variable_attributes       = 'class="variable"';

        if ($highlightOnly) {
            $html = SqlFormatter::highlight($sql);
            $html = preg_replace('/<pre class=".*">([^"]*+)<\/pre>/Us', '\1', $html);
        } else {
            $html = SqlFormatter::format($sql);
            $html = preg_replace('/<pre class="(.*)">([^"]*+)<\/pre>/Us', '<div class="\1"><pre>\2</pre></div>', $html);
        }

        return $html;
    }

    /**
     * Get the name of the extension
     *
     * @return string
     */
    public function getName()
    {
        return 'doctrine_extension';
    }
}
