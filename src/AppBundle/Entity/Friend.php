<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;

/**
 * Class Friend
 *
 * @ORM\Entity()
 * @ORM\Table(name="friends")
 */
class Friend
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
}
