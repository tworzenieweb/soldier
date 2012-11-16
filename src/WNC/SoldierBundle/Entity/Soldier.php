<?php

namespace WNC\SoldierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * WNC\SoldierBundle\Entity\Soldier
 *
 * @ORM\Table(name="soldier")
 * @ORM\Entity(repositoryClass="WNC\SoldierBundle\Entity\SoldierRepository")
 */
class Soldier
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
     * @var string $mothers_name
     *
     * @ORM\Column(name="mothers_name", type="string", length=100)
     */
    private $mothers_name;

    /**
     * @var string $army_unit
     *
     * @ORM\Column(name="army_unit", type="string", length=100, nullable=true)
     */
    private $army_unit;

    /**
     * @var integer $gender
     * @ORM\Column(name="gender", type="smallint", type="string", columnDefinition="ENUM('male', 'female')")
     */
    private $gender;

    
    /**
     * @var string $self_description
     *
     * @ORM\Column(name="self_description", type="string", length=1000, nullable=true)
     */
    private $self_description;

    /**
    *
    * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="video_id", referencedColumnName="id", nullable=true)
    */
    private $video;
    
    private $video_id;


    /**
     * @var string $comments
     *
     * @ORM\Column(name="comments", type="string", length=1000, nullable=true)
     */
    private $comments;

    
   /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="soldier", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
    * @var  integer $userid
    */
    private $user_id;
    
    
   /**
    *
    * @ORM\ManyToOne(targetEntity="WNC\SoldierBundle\Entity\Participant", cascade={"persist", "remove"}, inversedBy="soldiers")
    * @ORM\JoinColumn(name="participant_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
    */
    private $participant;

    /**
    * @var  integer $owner_id
    */
    private $participant_id;
    
    
    /**
     * @ORM\Column(name="service_end_date", type="datetime")
     */
    private $service_end_date;
    
    
   /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="soldiers", cascade={"persist"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    private $city;
    
    /**
     *
     * @var integer $city_id
     */
    private $city_id;

        
    
    /**
    *
    * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", nullable=true)
    */
    private $picture;
    
    private $picture_id;
    
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
     * Set mothers_name
     *
     * @param string $mothersName
     * @return Soldier
     */
    public function setMothersName($mothersName)
    {
        $this->mothers_name = $mothersName;
    
        return $this;
    }

    /**
     * Get mothers_name
     *
     * @return string 
     */
    public function getMothersName()
    {
        return $this->mothers_name;
    }

    /**
     * Set army_unit
     *
     * @param string $armyUnit
     * @return Soldier
     */
    public function setArmyUnit($armyUnit)
    {
        $this->army_unit = $armyUnit;
    
        return $this;
    }

    /**
     * Get army_unit
     *
     * @return string 
     */
    public function getArmyUnit()
    {
        return $this->army_unit;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     * @return Soldier
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return integer 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Soldier
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    
        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set self_description
     *
     * @param string $selfDescription
     * @return Soldier
     */
    public function setSelfDescription($selfDescription)
    {
        $this->self_description = $selfDescription;
    
        return $this;
    }

    /**
     * Get self_description
     *
     * @return string 
     */
    public function getSelfDescription()
    {
        return $this->self_description;
    }
    

    /**
     * Set comments
     *
     * @param string $comments
     * @return Soldier
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    
        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }



    /**
     * Set user
     *
     * @param Application\Sonata\UserBundle\Entity\User $user
     * @return Soldier
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return Application\Sonata\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set service_end_date
     *
     * @param \DateTime $serviceEndDate
     * @return Soldier
     */
    public function setServiceEndDate($serviceEndDate)
    {
        $this->service_end_date = $serviceEndDate;
    
        return $this;
    }

    /**
     * Get service_end_date
     *
     * @return \DateTime 
     */
    public function getServiceEndDate()
    {
        return $this->service_end_date;
    }

    /**
     * Set city
     *
     * @param WNC\SoldierBundle\Entity\City $city
     * @return Soldier
     */
    public function setCity(\WNC\SoldierBundle\Entity\City $city = null)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return WNC\SoldierBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }
    


    public function getGenderValue()
    {
        
        return $this->gender ? 'female' : 'male';
        
    }

    
    public static function getLabel($key)
    {
        
        return isset(self::$_labels[$key]) ? self::$_labels[$key] : false;
        
    }
    
    public function getWantsToContactValue()
    {
        return $this->wants_to_contact ? 'yes' : 'no';
    }
    

    /**
     * Set participant
     *
     * @param WNC\SoldierBundle\Entity\Participant $participant
     * @return Soldier
     */
    public function setParticipant(\WNC\SoldierBundle\Entity\Participant $participant = null)
    {
        $this->participant = $participant;
    
        return $this;
    }

    /**
     * Get participant
     *
     * @return WNC\SoldierBundle\Entity\Participant 
     */
    public function getParticipant()
    {
        return $this->participant;
    }
    
    public function getCityId() {
      return $this->city_id;
    }
    public function setCityId($cityId) {
      
      $this->city_id = $cityId;
      
      return $this;
      
    }
    
    public function getUserId() {
      return $this->user_id;
    }
    public function setUserId($userId) {
      
      $this->user_id = $userId;
      
      return $this;
      
    }
    
    public function getFile()
    {
      return $this->file;
    }
    
    public function setFile($file)
    {
      $this->file = $file;
    }
    
    public function isServiceEndDateValid(ExecutionContext $context)
    {
      
        if($this->getVideo() && !$this->getVideo()->getName()) {
        
          $context->addViolationAtSubPath('video_id', 'Wrong youtube link', array(), null);       
        
        }   
      
        $date = $this->getServiceEndDate();
        
        $now = new \DateTime();
        
        if($date <= $now) {
          
          $context->addViolationAtSubPath('service_end_date', sprintf('Service end date need to be greater than %s', $now->format('d/m/Y')), array(), null);
          
        }

        
    }
    

    /**
     * Set video
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $video
     * @return Soldier
     */
    public function setVideo(\Application\Sonata\MediaBundle\Entity\Media $video)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return Application\Sonata\MediaBundle\Entity\Media 
     */
    public function getVideo()
    {
        return $this->video;
    }

    
    public function __toString() {
      return $this->getUser()->__toString();
    }
    
}
