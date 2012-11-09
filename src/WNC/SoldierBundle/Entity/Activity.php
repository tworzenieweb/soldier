<?php

namespace WNC\SoldierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;

/**
 * WNC\SoldierBundle\Entity\Activity
 *
 * @ORM\Table(name="activity")
 * @ORM\Entity(repositoryClass="WNC\SoldierBundle\Entity\ActivityRepository")
 */
class Activity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="activity")
     */
    private $participants;
    
    public function __construct() {
      $this->participants = ArrayCollection();
    }
    

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
     * @return Activity
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
     * Add participants
     *
     * @param WNC\SoldierBundle\Entity\Participant $participants
     * @return Activity
     */
    public function addParticipant(\WNC\SoldierBundle\Entity\Participant $participants)
    {
        $this->participants[] = $participants;
    
        return $this;
    }

    /**
     * Remove participants
     *
     * @param WNC\SoldierBundle\Entity\Participant $participants
     */
    public function removeParticipant(\WNC\SoldierBundle\Entity\Participant $participants)
    {
        $this->participants->removeElement($participants);
    }

    /**
     * Get participants
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParticipants()
    {
        return $this->participants;
    }
    
    public function __toString() {
      return $this->name;;
    }
}