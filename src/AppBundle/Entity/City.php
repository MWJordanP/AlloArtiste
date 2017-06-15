<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="city")
 */
class City
{
    use Timestampable;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=180)
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=180)
     */
    protected $simpleName;

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    protected $zipCode;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $latitude;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Department", inversedBy="cities")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $department;

    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="city")
     */
    protected $users;

    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSimpleName()
    {
        return $this->simpleName;
    }

    /**
     * @param string $simpleName
     *
     * @return City
     */
    public function setSimpleName($simpleName)
    {
        $this->simpleName = $simpleName;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     *
     * @return $this
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param mixed $department
     *
     * @return City
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return User[]|ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User[]|ArrayCollection $users
     *
     * @return City
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }
}
