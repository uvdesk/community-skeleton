<?php

namespace PhpParser;

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/PhpParser/CodeTestParser.php';
require __DIR__ . '/PhpParser/CodeParsingTest.php';

$dir = __DIR__ . '/code/parser';

$testParser = new CodeTestParser;
$codeParsingTest = new CodeParsingTest;
foreach (filesInDir($dir, 'test') as $fileName => $code) {
    if (false !== strpos($code, '@@{')) {
        // Skip tests with evaluate segments
        continue;
    }

    list($name, $tests) = $testParser->parseTest($code, 2);
    $newTests = [];
    foreach ($tests as list($modeLine, list($input, $expected))) {
        $modes = null !== $modeLine ? array_fill_keys(explode(',', $modeLine), true) : [];
        list($parser5, $parser7) = $codeParsingTest->createParsers($modes);
        list(, $output) = isset($modes['php5'])
            ? $codeParsingTest->getParseOutput($parser5, $input, $modes)
            : $codeParsingTest->getParseOutput($parser7, $input, $modes);
        $newTests[] = [$modeLine, [$input, $output]];
    }

    $newCode = $testParser->reconstructTest($name, $newTests);
    file_put_contents($fileName, $newCode);
}
