<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Reflection;

use Zend\Code\Scanner\CachingFileScanner;

use function basename;
use function count;
use function current;
use function file_get_contents;
use function get_included_files;
use function in_array;
use function realpath;
use function reset;
use function sprintf;
use function stream_resolve_include_path;
use function substr_count;

class FileReflection implements ReflectionInterface
{
    /**
     * @var string
     */
    protected $filePath;

    /**
     * @var string
     */
    protected $docComment;

    /**
     * @var int
     */
    protected $startLine = 1;

    /**
     * @var int
     */
    protected $endLine;

    /**
     * @var string[]
     */
    protected $namespaces = [];

    /**
     * @var string[]
     */
    protected $uses = [];

    /**
     * @var string[]
     */
    protected $requiredFiles = [];

    /**
     * @var ClassReflection[]
     */
    protected $classes = [];

    /**
     * @var FunctionReflection[]
     */
    protected $functions = [];

    /**
     * @var string
     */
    protected $contents;

    /**
     * @param  string $filename
     * @param  bool $includeIfNotAlreadyIncluded
     * @throws Exception\InvalidArgumentException If file does not exists
     * @throws Exception\RuntimeException If file exists but is not included or required
     */
    public function __construct($filename, $includeIfNotAlreadyIncluded = false)
    {
        if (($fileRealPath = realpath($filename)) === false) {
            $fileRealPath = stream_resolve_include_path($filename);
        }

        if (! $fileRealPath) {
            throw new Exception\InvalidArgumentException(sprintf(
                'No file for %s was found.',
                $filename
            ));
        }

        if (! in_array($fileRealPath, get_included_files())) {
            if (! $includeIfNotAlreadyIncluded) {
                throw new Exception\RuntimeException(sprintf(
                    'File %s must be required before it can be reflected',
                    $filename
                ));
            }

            include $fileRealPath;
        }

        $this->filePath = $fileRealPath;
        $this->reflect();
    }

    /**
     * Required by the Reflector interface.
     *
     * @todo   What should this do?
     * @return void
     */
    public static function export()
    {
    }

    /**
     * Return the file name of the reflected file
     *
     * @return string
     */
    public function getFileName()
    {
        return basename($this->filePath);
    }

    /**
     * Get the start line - Always 1, staying consistent with the Reflection API
     *
     * @return int
     */
    public function getStartLine()
    {
        return $this->startLine;
    }

    /**
     * Get the end line / number of lines
     *
     * @return int
     */
    public function getEndLine()
    {
        return $this->endLine;
    }

    /**
     * @return string
     */
    public function getDocComment()
    {
        return $this->docComment;
    }

    /**
     * @return DocBlockReflection|false
     */
    public function getDocBlock()
    {
        if (! ($docComment = $this->getDocComment())) {
            return false;
        }

        $instance = new DocBlockReflection($docComment);

        return $instance;
    }

    /**
     * @return string[]
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        if (count($this->namespaces) == 0) {
            return;
        }

        return $this->namespaces[0];
    }

    /**
     * @return array
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * Return the reflection classes of the classes found inside this file
     *
     * @return ClassReflection[]
     */
    public function getClasses()
    {
        $classes = [];
        foreach ($this->classes as $class) {
            $classes[] = new ClassReflection($class);
        }

        return $classes;
    }

    /**
     * Return the reflection functions of the functions found inside this file
     *
     * @return FunctionReflection[]
     */
    public function getFunctions()
    {
        $functions = [];
        foreach ($this->functions as $function) {
            $functions[] = new FunctionReflection($function);
        }

        return $functions;
    }

    /**
     * Retrieve the reflection class of a given class found in this file
     *
     * @param  null|string $name
     * @return ClassReflection
     * @throws Exception\InvalidArgumentException for invalid class name or invalid reflection class
     */
    public function getClass($name = null)
    {
        if (null === $name) {
            reset($this->classes);
            $selected = current($this->classes);

            return new ClassReflection($selected);
        }

        if (in_array($name, $this->classes)) {
            return new ClassReflection($name);
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Class by name %s not found.',
            $name
        ));
    }

    /**
     * Return the full contents of file
     *
     * @return string
     */
    public function getContents()
    {
        return file_get_contents($this->filePath);
    }

    public function toString()
    {
        return ''; // @todo
    }

    /**
     * Serialize to string
     *
     * Required by the Reflector interface
     *
     * @todo   What should this serialization look like?
     * @return string
     */
    public function __toString()
    {
        return '';
    }

    /**
     * This method does the work of "reflecting" the file
     *
     * Uses Zend\Code\Scanner\FileScanner to gather file information
     *
     * @return void
     */
    protected function reflect()
    {
        $scanner             = new CachingFileScanner($this->filePath);
        $this->docComment    = $scanner->getDocComment();
        $this->requiredFiles = $scanner->getIncludes();
        $this->classes       = $scanner->getClassNames();
        $this->namespaces    = $scanner->getNamespaces();
        $this->uses          = $scanner->getUses();
    }

    /**
     * Validate / check a file level DocBlock
     *
     * @param  array $tokens Array of tokenizer tokens
     * @return void
     */
    protected function checkFileDocBlock($tokens)
    {
        foreach ($tokens as $token) {
            $type    = $token[0];
            $value   = $token[1];
            $lineNum = $token[2];
            if (($type == T_OPEN_TAG) || ($type == T_WHITESPACE)) {
                continue;
            } elseif ($type == T_DOC_COMMENT) {
                $this->docComment = $value;
                $this->startLine  = $lineNum + substr_count($value, "\n") + 1;

                return;
            } else {
                // Only whitespace is allowed before file DocBlocks
                return;
            }
        }
    }
}
