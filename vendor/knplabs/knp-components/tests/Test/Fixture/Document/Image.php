<?php

namespace Test\Fixture\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
final class Image
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\Field
     */
    private $title;

    /**
     * @ODM\File
     */
    private $file;

    /**
     * Set file.
     *
     * @param integer $file
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * Get file.
     *
     * @return integer
     */
    public function getFile()
    {
        return $this->file;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
