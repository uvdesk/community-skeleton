<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Annotation\Parser;

use Zend\EventManager\EventInterface;

interface ParserInterface
{
    /**
     * Respond to the "createAnnotation" event
     *
     * @param  EventInterface  $e
     * @return false|\stdClass
     */
    public function onCreateAnnotation(EventInterface $e);

    /**
     * Register an annotation this parser will accept
     *
     * @param  mixed $annotation
     * @return void
     */
    public function registerAnnotation($annotation);

    /**
     * Register multiple annotations this parser will accept
     *
     * @param  array|\Traversable $annotations
     * @return void
     */
    public function registerAnnotations($annotations);
}
