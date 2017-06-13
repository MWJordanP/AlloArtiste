<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="departments")
 */
class Department
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
     * @ORM\Column(type="string", length=5)
     */
    protected $simpleNum;

    /**
     * @var City[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\City", mappedBy="department")
     */
    protected $cities;

    /**
     * Department constructor.
     */
    public function __construct()
    {
        $this->cities = new ArrayCollection();
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
     * @return Department
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
     * @return Department
     */
    public function setSimpleName($simpleName)
    {
        $this->simpleName = $simpleName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSimpleNum()
    {
        return $this->simpleNum;
    }

    /**
     * @param string $simpleNum
     *
     * @return Department
     */
    public function setSimpleNum($simpleNum)
    {
        $this->simpleNum = $simpleNum;

        return $this;
    }

    /**
     * @return City[]|ArrayCollection
     */
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * @param City[]|ArrayCollection $cities
     *
     * @return $this
     */
    public function setCities($cities)
    {
        $this->cities = $cities;

        return $this;
    }

    /**
     * @param City $cities
     *
     * @return boolean
     */
    public function hasCities($cities)
    {
        return $this->getCities()->contains($cities);
    }

    /**
     * @param City $city
     *
     * @return $this
     */
    public function addCity(City $city)
    {
        if (!$this->getCities()->contains($city)) {
            $this->getCities()->add($city);
        }

        return $this;
    }

    /**
     * Remove city
     *
     * @param City $city
     */
    public function removeCity(City $city)
    {
        $this->cities->removeElement($city);
    }
}
