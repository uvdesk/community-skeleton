<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/** 
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="uv_ticket_attachments")
 */

class Attachment
{
    /**
     * @var integer
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * 
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Attachment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @var string
     * @ORM\Column(name="path", type="text", nullable=true)
     */
    private $path;


    /**
     * Set path
     *
     * @param string $path
     * @return Attachment
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * @var \Webkul\TicketBundle\Entity\Thread
     * 
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="attachments")
     * @ORM\JoinColumn(name="thread_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $thread;


    /**
     * Set thread
     *
     * @param \Webkul\TicketBundle\Entity\Thread $thread
     * @return Attachment
     * 
     */
    public function setThread(\Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }
    
    /**
     * @var string
     * 
     * @ORM\Column(name="content_type", length=255, type="string", nullable=true)
     */
    private $contentType;

    /**
     * @var integer
     * 
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @var string
     * 
     * 
     */
    public $attachmentThumb;

    public function getAttachmentThumb()
    {
        return $this->attachmentThumb;
    }

    /**
     * @var integer
     */
    public $attachmentOrginal;

    public function getAttachmentOrginal()
    {
        return $this->attachmentOrginal;
    }

    /**
     * Set contentType
     *
     * @param string $contentType
     * @return Attachment
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType
     *
     * @return string 
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Attachment
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer 
     */
    public function getSize()
    {
        return $this->size;
    }
    /**
     * @var string
     * 
     * @ORM\Column(name="content_id", type="string", length=255, nullable=true)
     */
    private $contentId;


    /**
     * Set contentId
     *
     * @param string $contentId
     * @return Attachment
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;

        return $this;
    }

    /**
     * Get contentId
     *
     * @return string 
     */
    public function getContentId()
    {
        return $this->contentId;
    }
    /**
     * @var string
     * 
     * @ORM\Column(name="file_system", type="string", length=255, nullable=true)
     */
    private $fileSystem;


    /**
     * Set fileSystem
     *
     * @param string $fileSystem
     * @return Attachment
     */
    public function setFileSystem($fileSystem)
    {
        $this->fileSystem = $fileSystem;

        return $this;
    }

    /**
     * Get fileSystem
     *
     * @return string 
     */
    public function getFileSystem()
    {
        return $this->fileSystem;
    }
}
