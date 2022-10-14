<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * TicketRating
 * @ORM\Entity(repositoryClass="Webkul\UVDesk\CoreFrameworkBundle\Repository\TicketRatingRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="uv_ticket_rating")
 */
class TicketRating
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $stars = 0;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $feedback;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="ratings")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $ticket;

    /**
     * @var \Webkul\UVDesk\CoreFrameworkBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $customer;


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
     * Set stars
     *
     * @param integer $stars
     *
     * @return TicketRating
     */
    public function setStars($stars)
    {
        $this->stars = $stars;

        return $this;
    }

    /**
     * Get stars
     *
     * @return integer
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * Set feedback
     *
     * @param string $feedback
     *
     * @return TicketRating
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * Get feedback
     *
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TicketRating
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set ticket
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket $ticket
     *
     * @return TicketRating
     */
    public function setTicket(\Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set customer
     *
     * @param \Webkul\UVDesk\CoreFrameworkBundle\Entity\User $customer
     *
     * @return TicketRating
     */
    public function setCustomer(\Webkul\UVDesk\CoreFrameworkBundle\Entity\User $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Webkul\UVDesk\CoreFrameworkBundle\Entity\User
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}

