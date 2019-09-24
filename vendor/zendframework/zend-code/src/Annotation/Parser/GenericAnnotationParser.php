<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Annotation\Parser;

use Traversable;
use Zend\Code\Annotation\AnnotationInterface;
use Zend\Code\Exception;
use Zend\EventManager\EventInterface;

use function array_search;
use function class_exists;
use function get_class;
use function gettype;
use function in_array;
use function is_array;
use function is_object;
use function is_string;
use function sprintf;
use function str_replace;
use function strtolower;
use function trim;

/**
 * Generic annotation parser
 *
 * Expects registration of AnnotationInterface instances. Such instances
 * will be passed annotation content to their initialize() method, which
 * they are then responsible for parsing.
 */
class GenericAnnotationParser implements ParserInterface
{
    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @var array
     */
    protected $annotationNames = [];

    /**
     * @var AnnotationInterface[]
     */
    protected $annotations = [];

    /**
     * Listen to onCreateAnnotation, and attempt to return an annotation object
     * instance.
     *
     * If the annotation class or alias is not registered, immediately returns
     * false. Otherwise, resolves the class, clones it, and, if any content is
     * present, calls {@link AnnotationInterface::initialize()} with the
     * content.
     *
     * @param  EventInterface $e
     * @return false|AnnotationInterface
     */
    public function onCreateAnnotation(EventInterface $e)
    {
        $class = $e->getParam('class', false);
        if (! $class || ! $this->hasAnnotation($class)) {
            return false;
        }

        $content = $e->getParam('content', '');
        $content = trim($content, '()');

        if ($this->hasAlias($class)) {
            $class = $this->resolveAlias($class);
        }

        $index      = array_search($class, $this->annotationNames);
        $annotation = $this->annotations[$index];

        $newAnnotation = clone $annotation;
        if ($content) {
            $newAnnotation->initialize($content);
        }

        return $newAnnotation;
    }

    /**
     * Register annotations
     *
     * @param  string|AnnotationInterface $annotation String class name of an
     *         AnnotationInterface implementation, or actual instance
     * @return void
     * @throws Exception\InvalidArgumentException
     */
    public function registerAnnotation($annotation)
    {
        $class = false;
        if (is_string($annotation) && class_exists($annotation)) {
            $class      = $annotation;
            $annotation = new $annotation();
        }

        if (! $annotation instanceof AnnotationInterface) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s: expects an instance of %s\AnnotationInterface; received "%s"',
                __METHOD__,
                __NAMESPACE__,
                is_object($annotation) ? get_class($annotation) : gettype($annotation)
            ));
        }

        $class = $class ?: get_class($annotation);

        if (in_array($class, $this->annotationNames)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'An annotation for this class %s already exists',
                $class
            ));
        }

        $this->annotations[]     = $annotation;
        $this->annotationNames[] = $class;
    }

    /**
     * Register many annotations at once
     *
     * @param  array|Traversable $annotations
     * @throws Exception\InvalidArgumentException
     * @return GenericAnnotationParser
     */
    public function registerAnnotations($annotations)
    {
        if (! is_array($annotations) && ! $annotations instanceof Traversable) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s: expects an array or Traversable; received "%s"',
                __METHOD__,
                is_object($annotations) ? get_class($annotations) : gettype($annotations)
            ));
        }

        foreach ($annotations as $annotation) {
            $this->registerAnnotation($annotation);
        }

        return $this;
    }

    /**
     * Checks if the manager has annotations for a class
     *
     * @param  string $class
     * @return bool
     */
    public function hasAnnotation($class)
    {
        if (in_array($class, $this->annotationNames)) {
            return true;
        }

        if ($this->hasAlias($class)) {
            return true;
        }

        return false;
    }

    /**
     * Alias an annotation name
     *
     * @param  string $alias
     * @param  string $class May be either a registered annotation name or another alias
     * @throws Exception\InvalidArgumentException
     * @return GenericAnnotationParser
     */
    public function setAlias($alias, $class)
    {
        if (! in_array($class, $this->annotationNames) && ! $this->hasAlias($class)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s: Cannot alias "%s" to "%s", as class "%s" is not currently a registered annotation or alias',
                __METHOD__,
                $alias,
                $class,
                $class
            ));
        }

        $alias = $this->normalizeAlias($alias);
        $this->aliases[$alias] = $class;

        return $this;
    }

    /**
     * Normalize an alias name
     *
     * @param  string $alias
     * @return string
     */
    protected function normalizeAlias($alias)
    {
        return strtolower(str_replace(['-', '_', ' ', '\\', '/'], '', $alias));
    }

    /**
     * Do we have an alias by the provided name?
     *
     * @param  string $alias
     * @return bool
     */
    protected function hasAlias($alias)
    {
        $alias = $this->normalizeAlias($alias);

        return isset($this->aliases[$alias]);
    }

    /**
     * Resolve an alias to a class name
     *
     * @param  string $alias
     * @return string
     */
    protected function resolveAlias($alias)
    {
        do {
            $normalized = $this->normalizeAlias($alias);
            $class      = $this->aliases[$normalized];
        } while ($this->hasAlias($class));

        return $class;
    }
}
