<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class User
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $street;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $picture;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $streetNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $token;

    /**
     * @var Tag[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="users", cascade={"persist"})
     */
    protected $tags;

    /**
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="Job", inversedBy="users")
     */
    protected $job;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="City", inversedBy="users")
     */
    protected $city;

    /**
     * @var Friend[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Friend", mappedBy="actor")
     */
    protected $friends;

    /**
     * @var Friend[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Friend", mappedBy="friend")
     */
    protected $inviteFriends;

    /**
     * @var Picture[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Picture", mappedBy="user")
     */
    protected $pictures;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tags          = new ArrayCollection();
        $this->pictures      = new ArrayCollection();
        $this->friends       = new ArrayCollection();
        $this->inviteFriends = new ArrayCollection();
        $this->token         = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return User
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @param string $streetNumber
     *
     * @return User
     */
    public function setStreetNumber($streetNumber)
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    /**
     * @return Tag[]|ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[]|ArrayCollection $tags
     *
     * @return User
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Friend[]|ArrayCollection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param Friend[]|ArrayCollection $friends
     *
     * @return User
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;

        return $this;
    }

    /**
     * @return Friend[]|ArrayCollection
     */
    public function getInviteFriends()
    {
        return $this->inviteFriends;
    }

    /**
     * @param Friend[]|ArrayCollection $inviteFriends
     *
     * @return User
     */
    public function setInviteFriends($inviteFriends)
    {
        $this->inviteFriends = $inviteFriends;

        return $this;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param Job $job
     *
     * @return User
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     *
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array|null
     */
    public function displayTags()
    {
        $tags = [];
        foreach ($this->tags as $tag) {
            $tags[] = [
                'id'   => $tag->getId(),
                'name' => $tag->getName(),
            ];
        }

        return !empty($tags) ? $tags : null;
    }

    /**
     * @return array|null
     */
    public function displayPictures()
    {
        $pictures = [];
        foreach ($this->pictures as $picture) {
            $pictures[] = [
                'id'   => $picture->getId(),
                'name' => $picture->getName(),
            ];
        }

        return !empty($pictures) ? $pictures : null;
    }

    /**
     * @return array|null
     */
    public function displayCity()
    {
        if (null !== $this->city) {
            return [
                'id'   => $this->city->getId(),
                'name' => $this->city->getName(),
            ];
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function displayJob()
    {
        if (null !== $this->job) {
            return [
                'id'   => $this->job->getId(),
                'name' => $this->job->getName(),
            ];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->firstName.' '.$this->lastName;
    }
}
