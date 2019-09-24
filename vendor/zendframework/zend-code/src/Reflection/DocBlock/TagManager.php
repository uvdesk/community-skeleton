<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Reflection\DocBlock;

use Zend\Code\Generic\Prototype\PrototypeClassFactory;
use Zend\Code\Reflection\DocBlock\Tag\TagInterface;

class TagManager extends PrototypeClassFactory
{
    /**
     * @return void
     */
    public function initializeDefaultTags()
    {
        $this->addPrototype(new Tag\ParamTag());
        $this->addPrototype(new Tag\ReturnTag());
        $this->addPrototype(new Tag\MethodTag());
        $this->addPrototype(new Tag\PropertyTag());
        $this->addPrototype(new Tag\AuthorTag());
        $this->addPrototype(new Tag\LicenseTag());
        $this->addPrototype(new Tag\ThrowsTag());
        $this->addPrototype(new Tag\VarTag());
        $this->setGenericPrototype(new Tag\GenericTag());
    }

    /**
     * @param string $tagName
     * @param string $content
     * @return TagInterface
     */
    public function createTag($tagName, $content = null)
    {
        /* @var TagInterface $newTag */
        $newTag = $this->getClonedPrototype($tagName);

        if ($content) {
            $newTag->initialize($content);
        }

        return $newTag;
    }
}
