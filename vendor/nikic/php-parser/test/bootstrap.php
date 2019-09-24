<?php

namespace PhpParser;

require __DIR__ . '/../vendor/autoload.php';

function canonicalize($str) {
    // normalize EOL style
    $str = str_replace("\r\n", "\n", $str);

    // trim newlines at end
    $str = rtrim($str, "\n");

    // remove trailing whitespace on all lines
    $lines = explode("\n", $str);
    $lines = array_map(function($line) {
        return rtrim($line, " \t");
    }, $lines);
    return implode("\n", $lines);
}

function filesInDir($directory, $fileExtension) {
    $directory = realpath($directory);
    $it = new \RecursiveDirectoryIterator($directory);
    $it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::LEAVES_ONLY);
    $it = new \RegexIterator($it, '(\.' . preg_quote($fileExtension) . '$)');
    foreach ($it as $file) {
        $fileName = $file->getPathname();
        yield $fileName => file_get_contents($fileName);
    }
}
