<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator\DocBlock\Tag;

use Zend\Code\Generator\AbstractGenerator;

use function explode;
use function implode;
use function is_string;

/**
 * This abstract class can be used as parent for all tags
 * that use a type part in their content.
 *
 * @see http://www.phpdoc.org/docs/latest/for-users/phpdoc/types.html
 */
abstract class AbstractTypeableTag extends AbstractGenerator
{
    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @param string|string[] $types
     * @param string          $description
     */
    public function __construct($types = [], $description = null)
    {
        if (! empty($types)) {
            $this->setTypes($types);
        }

        if (! empty($description)) {
            $this->setDescription($description);
        }
    }

    /**
     * @param string $description
     * @return AbstractTypeableTag
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Array of types or string with types delimited by pipe (|)
     * e.g. array('int', 'null') or "int|null"
     *
     * @param array|string $types
     * @return AbstractTypeableTag
     */
    public function setTypes($types)
    {
        if (is_string($types)) {
            $types = explode('|', $types);
        }
        $this->types = $types;
        return $this;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function getTypesAsString($delimiter = '|')
    {
        return implode($delimiter, $this->types);
    }
}
