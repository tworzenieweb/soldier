<?php

namespace WNC\SoldierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;

/**
 * WNC\SoldierBundle\Entity\Participant
 *
 * @ORM\Table(name="participant")
 * @ORM\Entity(repositoryClass="WNC\SoldierBundle\Entity\ParticipantRepository")
 */
class Participant
{
    
    private static $_labels = array(
        'wants_to_contact' => 'Do you want to be in contact with people on whose behalf you are participating'
    );
    
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    
    
    /**
     * @var integer $gender
     * @ORM\Column(name="gender", type="smallint", type="string", columnDefinition="ENUM('male', 'female')")
     */
    private $gender;
    
    /**
     * @var integer $gender
     * @ORM\Column(name="volunteer", type="smallint", type="string", columnDefinition="ENUM('no', 'yes')")
     */
    private $volunteer;

    /**
     * @var integer $gender
     * @ORM\Column(name="occupation", type="string", length=255)
     */
    private $occupation;
    
    
    /**
    *
    * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="picture_id", referencedColumnName="id", nullable=true)
    */
    private $picture;
    
    private $picture_id;

    /**
     * @var string $picture
     * @ORM\Column(name="organization", type="string", length=255)
     */
    private $organization;

    /**
     * @var string $picture
     * @ORM\Column(name="phone_number", type="string", length=15)
     */
    private $phone_number;
    
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
     * @var \DateTime $activity_start_date
     *
     * @ORM\Column(name="activity_start_date", type="date")
     */
    private $activity_start_date;

    /**
     * @var \DateTime $activity_end_date
     *
     * @ORM\Column(name="activity_end_date", type="date")
     */
    private $activity_end_date;
    
    /**
     * @var \DateTime $birth_date
     *
     * @ORM\Column(name="birth_date", type="date")
     */
    private $birth_date;
    
    /**
     * @var boolean $wants_to_contact
     *
     * @ORM\Column(name="wants_to_contact", type="boolean")
     */
    private $wants_to_contact;

    
   /**
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="participant")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
    * @var  integer $user_id
    */
    private $user_id;
    
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
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="participants", cascade={"persist"})
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     */
    private $activity;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Soldier", mappedBy="participant")
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=false)
     */
    private $soldiers;
    
    
    

    /**
     * @var string $self_description
     *
     * @ORM\Column(name="self_description", type="string", length=1000, nullable=true)
     */
    private $self_description;
    
    
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
     * Set activity_start_date
     *
     * @param \DateTime $activityStartDate
     * @return Participant
     */
    public function setActivityStartDate($activityStartDate)
    {
        $this->activity_start_date = $activityStartDate;
    
        return $this;
    }

    /**
     * Get activity_start_date
     *
     * @return \DateTime 
     */
    public function getActivityStartDate()
    {
        return $this->activity_start_date;
    }

    /**
     * Set activity_end_date
     *
     * @param \DateTime $activityEndDate
     * @return Participant
     */
    public function setActivityEndDate($activityEndDate)
    {
        $this->activity_end_date = $activityEndDate;
    
        return $this;
    }

    /**
     * Get activity_end_date
     *
     * @return \DateTime 
     */
    public function getActivityEndDate()
    {
        return $this->activity_end_date;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return Participant
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }
    
    public function getGenderValue()
    {
        
        return $this->gender ? 'female' : 'male';
        
    }

    /**
     * Set volunteer
     *
     * @param string $volunteer
     * @return Participant
     */
    public function setVolunteer($volunteer)
    {
        $this->volunteer = $volunteer;
    
        return $this;
    }

    /**
     * Get volunteer
     *
     * @return string 
     */
    public function getVolunteer()
    {
        return $this->volunteer;
    }

    /**
     * Set occupation
     *
     * @param string $occupation
     * @return Participant
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
    
        return $this;
    }

    /**
     * Get occupation
     *
     * @return string 
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Participant
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
     * Set organization
     *
     * @param string $organization
     * @return Participant
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    
        return $this;
    }

    /**
     * Get organization
     *
     * @return string 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set phone_number
     *
     * @param string $phoneNumber
     * @return Participant
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phone_number = $phoneNumber;
    
        return $this;
    }

    /**
     * Get phone_number
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }


    /**
     * Set comments
     *
     * @param string $comments
     * @return Participant
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
     * Set wants_to_contact
     *
     * @param boolean $wantsToContact
     * @return Participant
     */
    public function setWantsToContact($wantsToContact)
    {
        $this->wants_to_contact = $wantsToContact;
    
        return $this;
    }

    /**
     * Get wants_to_contact
     *
     * @return boolean 
     */
    public function getWantsToContact()
    {
        return $this->wants_to_contact;
    }
    
    public function getWantsToContactText()
    {
        return $this->wants_to_contact ? 'yes' : 'no';
    }

    /**
     * Set user
     *
     * @param Application\Sonata\UserBundle\Entity\User $user
     * @return Participant
     */
    public function setUser(\Application\Sonata\UserBundle\Entity\User $user)
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
     * Set city
     *
     * @param WNC\SoldierBundle\Entity\City $city
     * @return Participant
     */
    public function setCity(\WNC\SoldierBundle\Entity\City $city)
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
    
    
    public static function getLabel($key)
    {
        
        return isset(self::$_labels[$key]) ? self::$_labels[$key] : false;
        
    }
    

    /**
     * Set birth_date
     *
     * @param \DateTime $birthDate
     * @return Participant
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;
    
        return $this;
    }

    /**
     * Get birth_date
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }
    


    /**
     * Set activity
     *
     * @param WNC\SoldierBundle\Entity\Activity $activity
     * @return Participant
     */
    public function setActivity(\WNC\SoldierBundle\Entity\Activity $activity)
    {
        $this->activity = $activity;
    
        return $this;
    }

    /**
     * Get activity
     *
     * @return WNC\SoldierBundle\Entity\Activity 
     */
    public function getActivity()
    {
        return $this->activity;
    }
    
    public function getCityId() {
      return $this->city_id;
    }
    public function setCityId($cityId) {
      
      $this->city_id = $cityId;
      
      return $this;
      
    }
    
    

    /**
     * Add soldiers
     *
     * @param WNC\SoldierBundle\Entity\Soldier $soldiers
     * @return Participant
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->soldiers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set self_description
     *
     * @param string $selfDescription
     * @return Participant
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
    
    public function isActivityDatesValid(ExecutionContext $context)
    {
    
        if($this->getVideo() && !$this->getVideo()->getName()) {
        
          $context->addViolationAtSubPath('video_id', 'Wrong youtube link', array(), null);       
        
        }        
        
    
        $start = $this->getActivityStartDate();
        $end = $this->getActivityEndDate();
        $birth = $this->getBirthDate();

        if(!$start || !$end || !$birth) {
            $context->addViolation('Birth date, and activity boundaries need to be filled');
            return;
        }

        $now = new \DateTime();
        $now->setTime(0,0,0);
        
        $birthConstraint = new \DateTime();
        $birthConstraint->setDate(date('Y') - 18, 1, 1);       
        
        #var_dump($birth, $birthConstraint); exit;
        
        if($birth > $birthConstraint)
            $context->addViolationAtSubPath('birth_date', 'You need to be adult to participate', array(), null);               
        
        if($start < $now) {
            $context->addViolationAtSubPath('activity_start_date', sprintf('Activity start date need to start from %s', $now->format('m/d/Y')), array(), null);       
        }
        
        if($start >= $end) {
            $context->addViolationAtSubPath('activity_end_date', sprintf('Activity end date need to be greater than %s', $start->format('m/d/Y')), array(), null);       
        }
        

        
    }
    

    /**
     * Set video
     *
     * @param Application\Sonata\MediaBundle\Entity\Media $video
     * @return Participant
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
}
