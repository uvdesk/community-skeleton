<?php

error_reporting(E_ALL | E_STRICT);
ini_set('short_open_tag', false);

if ('cli' !== php_sapi_name()) {
    die('This script is designed for running on the command line.');
}

function showHelp($error) {
    die($error . "\n\n" .
<<<OUTPUT
This script has to be called with the following signature:

    php run.php [--no-progress] testType pathToTestFiles

The test type must be one of: PHP5, PHP7 or Symfony.

The following options are available:

    --no-progress    Disables showing which file is currently tested.

OUTPUT
    );
}

$options = array();
$arguments = array();

// remove script name from argv
array_shift($argv);

foreach ($argv as $arg) {
    if ('-' === $arg[0]) {
        $options[] = $arg;
    } else {
        $arguments[] = $arg;
    }
}

if (count($arguments) !== 2) {
    showHelp('Too little arguments passed!');
}

$showProgress = true;
$verbose = false;
foreach ($options as $option) {
    if ($option === '--no-progress') {
        $showProgress = false;
    } elseif ($option === '--verbose') {
        $verbose = true;
    } else {
        showHelp('Invalid option passed!');
    }
}

$testType = $arguments[0];
$dir = $arguments[1];

switch ($testType) {
    case 'Symfony':
        $version = 'Php7';
        $fileFilter = function($path) {
            if (!preg_match('~\.php$~', $path)) {
                return false;
            }

            if (preg_match('~(?:
# invalid php code
  dependency-injection.Tests.Fixtures.xml.xml_with_wrong_ext
# difference in nop statement
| framework-bundle.Resources.views.Form.choice_widget_options\.html
# difference due to INF
| yaml.Tests.InlineTest
)\.php$~x', $path)) {
                return false;
            }

            return true;
        };
        $codeExtractor = function($file, $code) {
            return $code;
        };
        break;
    case 'PHP5':
    case 'PHP7':
    $version = $testType === 'PHP5' ? 'Php5' : 'Php7';
        $fileFilter = function($path) {
            return preg_match('~\.phpt$~', $path);
        };
        $codeExtractor = function($file, $code) {
            if (preg_match('~(?:
# skeleton files
  ext.gmp.tests.001
| ext.skeleton.tests.00\d
# multibyte encoded files
| ext.mbstring.tests.zend_multibyte-01
| Zend.tests.multibyte.multibyte_encoding_001
| Zend.tests.multibyte.multibyte_encoding_004
| Zend.tests.multibyte.multibyte_encoding_005
# invalid code due to missing WS after opening tag
| tests.run-test.bug75042-3
# pretty print difference due to INF vs 1e1000
| ext.standard.tests.general_functions.bug27678
| tests.lang.bug24640
| Zend.tests.bug74947
# pretty print differences due to negative LNumbers
| Zend.tests.neg_num_string
| Zend.tests.bug72918
# pretty print difference due to nop statements
| ext.mbstring.tests.htmlent
| ext.standard.tests.file.fread_basic
# its too hard to emulate these on old PHP versions
| Zend.tests.flexible-heredoc-complex-test[1-4]
)\.phpt$~x', $file)) {
                return null;
            }

            if (!preg_match('~--FILE--\s*(.*?)\n--[A-Z]+--~s', $code, $matches)) {
                return null;
            }
            if (preg_match('~--EXPECT(?:F|REGEX)?--\s*(?:Parse|Fatal) error~', $code)) {
                return null;
            }

            return $matches[1];
        };
        break;
    default:
        showHelp('Test type must be one of: PHP5, PHP7 or Symfony');
}

require_once __DIR__ . '/../vendor/autoload.php';

$lexer = new PhpParser\Lexer\Emulative(['usedAttributes' => [
    'comments', 'startLine', 'endLine', 'startTokenPos', 'endTokenPos',
]]);
$parserName = 'PhpParser\Parser\\' . $version;
/** @var PhpParser\Parser $parser */
$parser = new $parserName($lexer);
$prettyPrinter = new PhpParser\PrettyPrinter\Standard;
$nodeDumper = new PhpParser\NodeDumper;

$cloningTraverser = new PhpParser\NodeTraverser;
$cloningTraverser->addVisitor(new PhpParser\NodeVisitor\CloningVisitor);

$parseFail = $fpppFail = $ppFail = $compareFail = $count = 0;

$readTime = $parseTime = $cloneTime = 0;
$fpppTime = $ppTime = $reparseTime = $compareTime = 0;
$totalStartTime = microtime(true);

foreach (new RecursiveIteratorIterator(
             new RecursiveDirectoryIterator($dir),
             RecursiveIteratorIterator::LEAVES_ONLY)
         as $file) {
    if (!$fileFilter($file)) {
        continue;
    }

    $startTime = microtime(true);
    $origCode = file_get_contents($file);
    $readTime += microtime(true) - $startTime;

    if (null === $origCode = $codeExtractor($file, $origCode)) {
        continue;
    }

    set_time_limit(10);

    ++$count;

    if ($showProgress) {
        echo substr(str_pad('Testing file ' . $count . ': ' . substr($file, strlen($dir)), 79), 0, 79), "\r";
    }

    try {
        $startTime = microtime(true);
        $origStmts = $parser->parse($origCode);
        $parseTime += microtime(true) - $startTime;

        $origTokens = $lexer->getTokens();

        $startTime = microtime(true);
        $stmts = $cloningTraverser->traverse($origStmts);
        $cloneTime += microtime(true) - $startTime;

        $startTime = microtime(true);
        $code = $prettyPrinter->printFormatPreserving($stmts, $origStmts, $origTokens);
        $fpppTime += microtime(true) - $startTime;

        if ($code !== $origCode) {
            echo $file, ":\n Result of format-preserving pretty-print differs\n";
            if ($verbose) {
                echo "FPPP output:\n=====\n$code\n=====\n\n";
            }

            ++$fpppFail;
        }

        $startTime = microtime(true);
        $code = "<?php\n" . $prettyPrinter->prettyPrint($stmts);
        $ppTime += microtime(true) - $startTime;

        try {
            $startTime = microtime(true);
            $ppStmts = $parser->parse($code);
            $reparseTime += microtime(true) - $startTime;

            $startTime = microtime(true);
            $same = $nodeDumper->dump($stmts) == $nodeDumper->dump($ppStmts);
            $compareTime += microtime(true) - $startTime;

            if (!$same) {
                echo $file, ":\n    Result of initial parse and parse after pretty print differ\n";
                if ($verbose) {
                    echo "Pretty printer output:\n=====\n$code\n=====\n\n";
                }

                ++$compareFail;
            }
        } catch (PhpParser\Error $e) {
            echo $file, ":\n    Parse of pretty print failed with message: {$e->getMessage()}\n";
            if ($verbose) {
                echo "Pretty printer output:\n=====\n$code\n=====\n\n";
            }

            ++$ppFail;
        }
    } catch (PhpParser\Error $e) {
        echo $file, ":\n    Parse failed with message: {$e->getMessage()}\n";

        ++$parseFail;
    } catch (Throwable $e) {
        echo $file, ":\n    Unknown error occurred: $e\n";
    }
}

if (0 === $parseFail && 0 === $ppFail && 0 === $compareFail) {
    $exit = 0;
    echo "\n\n", 'All tests passed.', "\n";
} else {
    $exit = 1;
    echo "\n\n", '==========', "\n\n", 'There were: ', "\n";
    if (0 !== $parseFail) {
        echo '    ', $parseFail,   ' parse failures.',        "\n";
    }
    if (0 !== $ppFail) {
        echo '    ', $ppFail,      ' pretty print failures.', "\n";
    }
    if (0 !== $fpppFail) {
        echo '    ', $fpppFail,      ' FPPP failures.', "\n";
    }
    if (0 !== $compareFail) {
        echo '    ', $compareFail, ' compare failures.',      "\n";
    }
}

echo "\n",
     'Tested files:         ', $count,        "\n",
     "\n",
     'Reading files took:   ', $readTime,    "\n",
     'Parsing took:         ', $parseTime,   "\n",
     'Cloning took:         ', $cloneTime,   "\n",
     'FPPP took:            ', $fpppTime,    "\n",
     'Pretty printing took: ', $ppTime,      "\n",
     'Reparsing took:       ', $reparseTime, "\n",
     'Comparing took:       ', $compareTime, "\n",
     "\n",
     'Total time:           ', microtime(true) - $totalStartTime, "\n",
     'Maximum memory usage: ', memory_get_peak_usage(true), "\n";

exit($exit);
