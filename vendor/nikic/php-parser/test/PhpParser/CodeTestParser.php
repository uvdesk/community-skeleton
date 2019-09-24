<?php declare(strict_types=1);

namespace PhpParser;

class CodeTestParser
{
    public function parseTest($code, $chunksPerTest) {
        $code = canonicalize($code);

        // evaluate @@{expr}@@ expressions
        $code = preg_replace_callback(
            '/@@\{(.*?)\}@@/',
            function($matches) {
                return eval('return ' . $matches[1] . ';');
            },
            $code
        );

        // parse sections
        $parts = preg_split("/\n-----(?:\n|$)/", $code);

        // first part is the name
        $name = array_shift($parts);

        // multiple sections possible with always two forming a pair
        $chunks = array_chunk($parts, $chunksPerTest);
        $tests = [];
        foreach ($chunks as $i => $chunk) {
            $lastPart = array_pop($chunk);
            list($lastPart, $mode) = $this->extractMode($lastPart);
            $tests[] = [$mode, array_merge($chunk, [$lastPart])];
        }

        return [$name, $tests];
    }

    public function reconstructTest($name, array $tests) {
        $result = $name;
        foreach ($tests as list($mode, $parts)) {
            $lastPart = array_pop($parts);
            foreach ($parts as $part) {
                $result .= "\n-----\n$part";
            }

            $result .= "\n-----\n";
            if (null !== $mode) {
                $result .= "!!$mode\n";
            }
            $result .= $lastPart;
        }
        return $result;
    }

    private function extractMode($expected) {
        $firstNewLine = strpos($expected, "\n");
        if (false === $firstNewLine) {
            $firstNewLine = strlen($expected);
        }

        $firstLine = substr($expected, 0, $firstNewLine);
        if (0 !== strpos($firstLine, '!!')) {
            return [$expected, null];
        }

        $expected = (string) substr($expected, $firstNewLine + 1);
        return [$expected, substr($firstLine, 2)];
    }
}
