<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

/**
 * Class slides
 *
 * @ORM\Entity()
 * @ORM\Table(name="slides")
 */
class Slide
{
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Picture
     *
     * @ORM\ManyToOne(targetEntity="Picture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $picture;

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
     * @return Slide
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param Picture $picture
     *
     * @return Slide
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }
}
