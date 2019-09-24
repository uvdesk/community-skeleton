<?php

namespace Test\Fixture\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Composite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(length=64)
     */
    private $title;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $uid;

    /**
     * Sets uid.
     *
     * @param mixed $uid
     */
    public function setUid($uid): void
    {
        $this->uid = $uid;
    }

    /**
     * Returns uid.
     *
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Sets Id.
     *
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Id.
     *
     * @return integer
     */
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
