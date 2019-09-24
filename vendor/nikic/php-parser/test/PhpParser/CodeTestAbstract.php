<?php declare(strict_types=1);

namespace PhpParser;

abstract class CodeTestAbstract extends \PHPUnit\Framework\TestCase
{
    protected function getTests($directory, $fileExtension, $chunksPerTest = 2) {
        $parser = new CodeTestParser;
        $allTests = [];
        foreach (filesInDir($directory, $fileExtension) as $fileName => $fileContents) {
            list($name, $tests) = $parser->parseTest($fileContents, $chunksPerTest);

            // first part is the name
            $name .= ' (' . $fileName . ')';
            $shortName = ltrim(str_replace($directory, '', $fileName), '/\\');

            // multiple sections possible with always two forming a pair
            foreach ($tests as $i => list($mode, $parts)) {
                $dataSetName = $shortName . (count($parts) > 1 ? '#' . $i : '');
                $allTests[$dataSetName] = array_merge([$name], $parts, [$mode]);
            }
        }

        return $allTests;
    }
}
