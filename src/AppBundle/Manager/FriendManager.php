<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Friend;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Class FriendManager
 */
class FriendManager extends AbstractManager
{

    protected $repository;

    /**
     * AbstractManager constructor.
     *
     * @param EntityManager $entityManager
     * @param Paginator     $paginator
     * @param RequestStack  $requestStack
     */
    public function __construct(EntityManager $entityManager, Paginator $paginator, RequestStack $requestStack)
    {
        parent::__construct($entityManager, $paginator, $requestStack);
        $this->repository = $entityManager->getRepository('AppBundle:Friend');
    }

    /**
     * @return Friend[]|array
     */
    public function getList()
    {
        return $this->repository->findBy([], ['id' => 'ASC']);
    }

    /**
     * @return PaginationInterface
     */
    public function getPaginateList()
    {
        return $this->paginate($this->getList());
    }

    /**
     * @param User $user
     * @param User $userAdd
     *
     * @return Friend
     */
    public function getByUserAndUserAdd(User $user, User $userAdd)
    {
        $friend = $this->repository->findOneBy(['actor' => $user, 'friend' => $userAdd]);

        return $friend;
    }

    /**
     * @param User $user
     *
     * @return Friend[]
     */
    public function getByUser(User $user)
    {
        $fiends = $this->repository->findBy(['actor' => $user]);

        return $fiends;
    }

    /**
     * @param User $user
     * @param User $userAdd
     *
     * @return Friend
     */
    public function create(User $user, User $userAdd)
    {
        $friend = new Friend();
        $friend
            ->setActor($user)
            ->setFriend($userAdd);

        $this->save($friend);

        return $friend;
    }

    /**
     * @param mixed $data
     *
     * @return array
     */
    public function convertArray($data)
    {
        if (is_array($data)) {
            $array = [];
            /** @var Friend $friend */
            foreach ($data as $friend) {
                $array[] = [
                    'Id'       => $friend->getFriend()->getId(),
                    'LastName' => $friend->getFriend()->getLastName(),
                    'FirsName' => $friend->getFriend()->getFirstName(),
                    'Phone'    => $friend->getFriend()->getPhone(),
                    'Email'    => $friend->getFriend()->getEmail(),
                    'Picture'  => $friend->getFriend()->getPicture(),
                ];
            }

            return $array;
        } else {
            return [
                'Id'       => $data->getFriend()->getId(),
                'LastName' => $data->getFriend()->getLastName(),
                'FirsName' => $data->getFriend()->getFirstName(),
                'Phone'    => $data->getFriend()->getPhone(),
                'Email'    => $data->getFriend()->getEmail(),
            ];
        }
    }
}
