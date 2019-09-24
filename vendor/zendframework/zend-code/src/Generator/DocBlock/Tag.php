<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator\DocBlock;

use Zend\Code\Generator\DocBlock\Tag\GenericTag;
use Zend\Code\Reflection\DocBlock\Tag\TagInterface as ReflectionTagInterface;

/**
 * @deprecated Deprecated in 2.3. Use GenericTag instead
 */
class Tag extends GenericTag
{
    /**
     * @param  ReflectionTagInterface $reflectionTag
     * @return Tag
     * @deprecated Deprecated in 2.3. Use TagManager::createTagFromReflection() instead
     */
    public static function fromReflection(ReflectionTagInterface $reflectionTag)
    {
        $tagManager = new TagManager();
        $tagManager->initializeDefaultTags();
        return $tagManager->createTagFromReflection($reflectionTag);
    }

    /**
     * @param  string $description
     * @return Tag
     * @deprecated Deprecated in 2.3. Use GenericTag::setContent() instead
     */
    public function setDescription($description)
    {
        return $this->setContent($description);
    }

    /**
     * @return string
     * @deprecated Deprecated in 2.3. Use GenericTag::getContent() instead
     */
    public function getDescription()
    {
        return $this->getContent();
    }
}
