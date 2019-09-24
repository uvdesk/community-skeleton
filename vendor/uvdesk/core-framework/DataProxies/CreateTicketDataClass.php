<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\DataProxies;

class CreateTicketDataClass
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $reply;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType
     */
    private $type;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return CreateTicketDataClass
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
     * Set from
     *
     * @param string $from
     *
     * @return CreateTicketDataClass
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return CreateTicketDataClass
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set reply
     *
     * @param string $reply
     *
     * @return CreateTicketDataClass
     */
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get reply
     *
     * @return string
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Set type
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType $type
     *
     * @return Ticket
     */
    public function setType(\Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType
     */
    public function getType()
    {
        return $this->type;
    }
}
