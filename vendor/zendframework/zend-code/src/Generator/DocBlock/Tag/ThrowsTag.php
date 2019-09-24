<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator\DocBlock\Tag;

class ThrowsTag extends AbstractTypeableTag implements TagInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'throws';
    }

    /**
     * @return string
     */
    public function generate()
    {
        $output = '@throws'
        . (! empty($this->types) ? ' ' . $this->getTypesAsString() : '')
        . (! empty($this->description) ? ' ' . $this->description : '');

        return $output;
    }
}
