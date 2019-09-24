<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator;

use function is_array;
use function is_string;
use function sprintf;

abstract class AbstractMemberGenerator extends AbstractGenerator
{
    /**#@+
     * @const int Flags for construction usage
     */
    const FLAG_ABSTRACT  = 0x01;
    const FLAG_FINAL     = 0x02;
    const FLAG_STATIC    = 0x04;
    const FLAG_INTERFACE = 0x08;
    const FLAG_PUBLIC    = 0x10;
    const FLAG_PROTECTED = 0x20;
    const FLAG_PRIVATE   = 0x40;
    /**#@-*/

    /**#@+
     * @param const string
     */
    const VISIBILITY_PUBLIC    = 'public';
    const VISIBILITY_PROTECTED = 'protected';
    const VISIBILITY_PRIVATE   = 'private';
    /**#@-*/

    /**
     * @var DocBlockGenerator
     */
    protected $docBlock;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $flags = self::FLAG_PUBLIC;

    /**
     * @param  int|array $flags
     * @return AbstractMemberGenerator
     */
    public function setFlags($flags)
    {
        if (is_array($flags)) {
            $flagsArray = $flags;
            $flags      = 0x00;
            foreach ($flagsArray as $flag) {
                $flags |= $flag;
            }
        }
        // check that visibility is one of three
        $this->flags = $flags;

        return $this;
    }

    /**
     * @param  int $flag
     * @return AbstractMemberGenerator
     */
    public function addFlag($flag)
    {
        $this->setFlags($this->flags | $flag);
        return $this;
    }

    /**
     * @param  int $flag
     * @return AbstractMemberGenerator
     */
    public function removeFlag($flag)
    {
        $this->setFlags($this->flags & ~$flag);
        return $this;
    }

    /**
     * @param  bool $isAbstract
     * @return AbstractMemberGenerator
     */
    public function setAbstract($isAbstract)
    {
        return $isAbstract ? $this->addFlag(self::FLAG_ABSTRACT) : $this->removeFlag(self::FLAG_ABSTRACT);
    }

    /**
     * @return bool
     */
    public function isAbstract()
    {
        return (bool) ($this->flags & self::FLAG_ABSTRACT);
    }

    /**
     * @param  bool $isInterface
     * @return AbstractMemberGenerator
     */
    public function setInterface($isInterface)
    {
        return $isInterface ? $this->addFlag(self::FLAG_INTERFACE) : $this->removeFlag(self::FLAG_INTERFACE);
    }

    /**
     * @return bool
     */
    public function isInterface()
    {
        return (bool) ($this->flags & self::FLAG_INTERFACE);
    }

    /**
     * @param  bool $isFinal
     * @return AbstractMemberGenerator
     */
    public function setFinal($isFinal)
    {
        return $isFinal ? $this->addFlag(self::FLAG_FINAL) : $this->removeFlag(self::FLAG_FINAL);
    }

    /**
     * @return bool
     */
    public function isFinal()
    {
        return (bool) ($this->flags & self::FLAG_FINAL);
    }

    /**
     * @param  bool $isStatic
     * @return AbstractMemberGenerator
     */
    public function setStatic($isStatic)
    {
        return $isStatic ? $this->addFlag(self::FLAG_STATIC) : $this->removeFlag(self::FLAG_STATIC);
    }

    /**
     * @return bool
     */
    public function isStatic()
    {
        return (bool) ($this->flags & self::FLAG_STATIC); // is FLAG_STATIC in flags
    }

    /**
     * @param  string $visibility
     * @return AbstractMemberGenerator
     */
    public function setVisibility($visibility)
    {
        switch ($visibility) {
            case self::VISIBILITY_PUBLIC:
                $this->removeFlag(self::FLAG_PRIVATE | self::FLAG_PROTECTED); // remove both
                $this->addFlag(self::FLAG_PUBLIC);
                break;
            case self::VISIBILITY_PROTECTED:
                $this->removeFlag(self::FLAG_PUBLIC | self::FLAG_PRIVATE); // remove both
                $this->addFlag(self::FLAG_PROTECTED);
                break;
            case self::VISIBILITY_PRIVATE:
                $this->removeFlag(self::FLAG_PUBLIC | self::FLAG_PROTECTED); // remove both
                $this->addFlag(self::FLAG_PRIVATE);
                break;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        switch (true) {
            case $this->flags & self::FLAG_PROTECTED:
                return self::VISIBILITY_PROTECTED;
            case $this->flags & self::FLAG_PRIVATE:
                return self::VISIBILITY_PRIVATE;
            default:
                return self::VISIBILITY_PUBLIC;
        }
    }

    /**
     * @param  string $name
     * @return AbstractMemberGenerator
     */
    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  DocBlockGenerator|string $docBlock
     * @throws Exception\InvalidArgumentException
     * @return AbstractMemberGenerator
     */
    public function setDocBlock($docBlock)
    {
        if (is_string($docBlock)) {
            $docBlock = new DocBlockGenerator($docBlock);
        } elseif (! $docBlock instanceof DocBlockGenerator) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s is expecting either a string, array or an instance of %s\DocBlockGenerator',
                __METHOD__,
                __NAMESPACE__
            ));
        }

        $this->docBlock = $docBlock;

        return $this;
    }

    /**
     * @return DocBlockGenerator
     */
    public function getDocBlock()
    {
        return $this->docBlock;
    }
}
