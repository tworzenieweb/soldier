<?php

namespace WNC\SoldierBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WNC\SoldierBundle\Entity\City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="WNC\SoldierBundle\Entity\CityRepository")
 */
class City
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
     * @ORM\OneToMany(targetEntity="Soldier", mappedBy="city")
     */
    private $soldiers;

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
     * @return City
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
    
    public function __construct()
    {
        $this->soldiers = new ArrayCollection();
    }

    /**
     * Add soldiers
     *
     * @param WNC\SoldierBundle\Entity\Soldier $soldiers
     * @return City
     */
    public function addSoldier(\WNC\SoldierBundle\Entity\Soldier $soldiers)
    {
        $this->soldiers[] = $soldiers;
    
        return $this;
    }

    /**
     * Remove soldiers
     *
     * @param WNC\SoldierBundle\Entity\Soldier $soldiers
     */
    public function removeSoldier(\WNC\SoldierBundle\Entity\Soldier $soldiers)
    {
        $this->soldiers->removeElement($soldiers);
    }

    /**
     * Get soldiers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSoldiers()
    {
        return $this->soldiers;
    }
    
    public function __toString() {
      return $this->name;
    }
}