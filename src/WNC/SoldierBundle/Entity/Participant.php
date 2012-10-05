<?php

namespace WNC\SoldierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

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
     * @var string $picture
     * @ORM\Column(name="picture", type="string", length=255)
     */
    private $picture;

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
     * @var string $video
     *
     * @ORM\Column(name="video", type="string", length=255)
     */
    private $video;
    
     /**
     * @var string $comments
     *
     * @ORM\Column(name="comments", type="string", length=1000)
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
    *
    * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", cascade={"persist", "remove"})
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
    */
    private $user;

    /**
    * @var  integer $userid
    */
    private $user_id;
    
    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="soldiers", cascade={"persist"})
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id", nullable=false)
     */
    private $city;
    
    
    /**
     * @var UploadedFile $file
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="picture")
     */
    public $file;
    

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
     * Set video
     *
     * @param string $video
     * @return Participant
     */
    public function setVideo($video)
    {
        $this->video = $video;
    
        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
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
    
    
        public function getAbsolutePath()
    {
        return null === $this->picture ? null : $this->getUploadRootDir().'/'.$this->picture;
    }

    public function getWebPath()
    {
        return null === $this->picture ? null : $this->getUploadDir().'/'.$this->picture;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/pictures';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        
        if($this->picture && file_exists($this->getAbsolutePath())) {
            unlink($this->getAbsolutePath());
        }
        
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->picture = uniqid().'.'.$this->file->guessExtension();
        }

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->picture);

    }
    
}