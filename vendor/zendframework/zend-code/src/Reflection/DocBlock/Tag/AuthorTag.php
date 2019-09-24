<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Reflection\DocBlock\Tag;

use function preg_match;
use function rtrim;

class AuthorTag implements TagInterface
{
    /**
     * @var string
     */
    protected $authorName;

    /**
     * @var string
     */
    protected $authorEmail;

    /**
     * @return string
     */
    public function getName()
    {
        return 'author';
    }

    /**
     * Initializer
     *
     * @param  string $tagDocblockLine
     */
    public function initialize($tagDocblockLine)
    {
        $match = [];

        if (! preg_match('/^([^\<]*)(\<([^\>]*)\>)?(.*)$/u', $tagDocblockLine, $match)) {
            return;
        }

        if ($match[1] !== '') {
            $this->authorName = rtrim($match[1]);
        }

        if (isset($match[3]) && $match[3] !== '') {
            $this->authorEmail = $match[3];
        }
    }

    /**
     * @return null|string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @return null|string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    public function __toString()
    {
        return 'DocBlock Tag [ * @' . $this->getName() . ' ]' . "\n";
    }
}
