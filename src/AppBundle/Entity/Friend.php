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

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="friends")
     */
    protected $actor;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="inviteFriends")
     */
    protected $friend;

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
     * @return Friend
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @param User $actor
     *
     * @return Friend
     */
    public function setActor($actor)
    {
        $this->actor = $actor;

        return $this;
    }

    /**
     * @return User
     */
    public function getFriend()
    {
        return $this->friend;
    }

    /**
     * @param User $friend
     *
     * @return Friend
     */
    public function setFriend($friend)
    {
        $this->friend = $friend;

        return $this;
    }
}
