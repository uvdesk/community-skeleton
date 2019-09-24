<?php

namespace Doctrine\Common\Reflection;

use Doctrine\Common\Annotations\TokenParser;
use ReflectionException;
use const T_CLASS;
use const T_DOC_COMMENT;
use const T_EXTENDS;
use const T_FUNCTION;
use const T_PAAMAYIM_NEKUDOTAYIM;
use const T_PRIVATE;
use const T_PROTECTED;
use const T_PUBLIC;
use const T_STRING;
use const T_USE;
use const T_VAR;
use const T_VARIABLE;
use function array_merge;
use function file_get_contents;
use function ltrim;
use function preg_match;
use function sprintf;
use function strpos;
use function strrpos;
use function strtolower;
use function substr;

/**
 * Parses a file for namespaces/use/class declarations.
 */
class StaticReflectionParser implements ReflectionProviderInterface
{
    /**
     * The fully qualified class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The short class name.
     *
     * @var string
     */
    protected $shortClassName;

    /**
     * Whether the caller only wants class annotations.
     *
     * @var bool
     */
    protected $classAnnotationOptimize;

    /**
     * A ClassFinder object which finds the class.
     *
     * @var ClassFinderInterface
     */
    protected $finder;

    /**
     * Whether the parser has run.
     *
     * @var bool
     */
    protected $parsed = false;

    /**
     * The namespace of the class.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * The use statements of the class.
     *
     * @var string[]
     */
    protected $useStatements = [];

    /**
     * The docComment of the class.
     *
     * @var mixed[]
     */
    protected $docComment = [
        'class' => '',
        'property' => [],
        'method' => [],
    ];

    /**
     * The name of the class this class extends, if any.
     *
     * @var string
     */
    protected $parentClassName = '';

    /**
     * The parent PSR-0 Parser.
     *
     * @var \Doctrine\Common\Reflection\StaticReflectionParser
     */
    protected $parentStaticReflectionParser;

    /**
     * Parses a class residing in a PSR-0 hierarchy.
     *
     * @param string               $className               The full, namespaced class name.
     * @param ClassFinderInterface $finder                  A ClassFinder object which finds the class.
     * @param bool                 $classAnnotationOptimize Only retrieve the class docComment.
     *                                                         Presumes there is only one statement per line.
     */
    public function __construct($className, $finder, $classAnnotationOptimize = false)
    {
        $this->className = ltrim($className, '\\');
        $lastNsPos       = strrpos($this->className, '\\');

        if ($lastNsPos !== false) {
            $this->namespace      = substr($this->className, 0, $lastNsPos);
            $this->shortClassName = substr($this->className, $lastNsPos + 1);
        } else {
            $this->shortClassName = $this->className;
        }

        $this->finder                  = $finder;
        $this->classAnnotationOptimize = $classAnnotationOptimize;
    }

    /**
     * @return void
     */
    protected function parse()
    {
        $fileName = $this->finder->findFile($this->className);

        if ($this->parsed || ! $fileName) {
            return;
        }
        $this->parsed = true;
        $contents     = file_get_contents($fileName);
        if ($this->classAnnotationOptimize) {
            $regex = sprintf('/\A.*^\s*((abstract|final)\s+)?class\s+%s\s+/sm', $this->shortClassName);

            if (preg_match($regex, $contents, $matches)) {
                $contents = $matches[0];
            }
        }
        $tokenParser = new TokenParser($contents);
        $docComment  = '';
        $last_token  = false;

        while ($token = $tokenParser->next(false)) {
            switch ($token[0]) {
                case T_USE:
                    $this->useStatements = array_merge($this->useStatements, $tokenParser->parseUseStatement());
                    break;
                case T_DOC_COMMENT:
                    $docComment = $token[1];
                    break;
                case T_CLASS:
                    if ($last_token !== T_PAAMAYIM_NEKUDOTAYIM) {
                        $this->docComment['class'] = $docComment;
                        $docComment                = '';
                    }
                    break;
                case T_VAR:
                case T_PRIVATE:
                case T_PROTECTED:
                case T_PUBLIC:
                    $token = $tokenParser->next();
                    if ($token[0] === T_VARIABLE) {
                        $propertyName                                = substr($token[1], 1);
                        $this->docComment['property'][$propertyName] = $docComment;
                        continue 2;
                    }
                    if ($token[0] !== T_FUNCTION) {
                        // For example, it can be T_FINAL.
                        continue 2;
                    }
                    // No break.
                case T_FUNCTION:
                    // The next string after function is the name, but
                    // there can be & before the function name so find the
                    // string.
                    while (($token = $tokenParser->next()) && $token[0] !== T_STRING) {
                        continue;
                    }
                    $methodName                              = $token[1];
                    $this->docComment['method'][$methodName] = $docComment;
                    $docComment                              = '';
                    break;
                case T_EXTENDS:
                    $this->parentClassName = $tokenParser->parseClass();
                    $nsPos                 = strpos($this->parentClassName, '\\');
                    $fullySpecified        = false;
                    if ($nsPos === 0) {
                        $fullySpecified = true;
                    } else {
                        if ($nsPos) {
                            $prefix  = strtolower(substr($this->parentClassName, 0, $nsPos));
                            $postfix = substr($this->parentClassName, $nsPos);
                        } else {
                            $prefix  = strtolower($this->parentClassName);
                            $postfix = '';
                        }
                        foreach ($this->useStatements as $alias => $use) {
                            if ($alias !== $prefix) {
                                continue;
                            }

                            $this->parentClassName = '\\' . $use . $postfix;
                            $fullySpecified        = true;
                        }
                    }
                    if (! $fullySpecified) {
                        $this->parentClassName = '\\' . $this->namespace . '\\' . $this->parentClassName;
                    }
                    break;
            }

            $last_token = $token[0];
        }
    }

    /**
     * @return StaticReflectionParser
     */
    protected function getParentStaticReflectionParser()
    {
        if (empty($this->parentStaticReflectionParser)) {
            $this->parentStaticReflectionParser = new static($this->parentClassName, $this->finder);
        }

        return $this->parentStaticReflectionParser;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getNamespaceName()
    {
        return $this->namespace;
    }

    /**
     * {@inheritDoc}
     */
    public function getReflectionClass()
    {
        return new StaticReflectionClass($this);
    }

    /**
     * {@inheritDoc}
     */
    public function getReflectionMethod($methodName)
    {
        return new StaticReflectionMethod($this, $methodName);
    }

    /**
     * {@inheritDoc}
     */
    public function getReflectionProperty($propertyName)
    {
        return new StaticReflectionProperty($this, $propertyName);
    }

    /**
     * Gets the use statements from this file.
     *
     * @return string[]
     */
    public function getUseStatements()
    {
        $this->parse();

        return $this->useStatements;
    }

    /**
     * Gets the doc comment.
     *
     * @param string $type The type: 'class', 'property' or 'method'.
     * @param string $name The name of the property or method, not needed for 'class'.
     *
     * @return string The doc comment, empty string if none.
     */
    public function getDocComment($type = 'class', $name = '')
    {
        $this->parse();

        return $name ? $this->docComment[$type][$name] : $this->docComment[$type];
    }

    /**
     * Gets the PSR-0 parser for the declaring class.
     *
     * @param string $type The type: 'property' or 'method'.
     * @param string $name The name of the property or method.
     *
     * @return StaticReflectionParser A static reflection parser for the declaring class.
     *
     * @throws ReflectionException
     */
    public function getStaticReflectionParserForDeclaringClass($type, $name)
    {
        $this->parse();
        if (isset($this->docComment[$type][$name])) {
            return $this;
        }
        if (! empty($this->parentClassName)) {
            return $this->getParentStaticReflectionParser()->getStaticReflectionParserForDeclaringClass($type, $name);
        }
        throw new ReflectionException('Invalid ' . $type . ' "' . $name . '"');
    }
}
