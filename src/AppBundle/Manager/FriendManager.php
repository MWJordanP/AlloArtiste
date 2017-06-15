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
                    'id'           => $friend->getFriend()->getId(),
                    'username'     => $friend->getFriend()->getUsername(),
                    'picture'      => $friend->getFriend()->getPicture(),
                    'street'       => $friend->getFriend()->getStreet(),
                    'streetNumber' => $friend->getFriend()->getStreetNumber(),
                    'job'          => null !== $friend->getFriend()->getJob() ? $friend->getFriend()->getJob()->getName() : null,
                    'city'         => null !== $friend->getFriend()->getCity() ? $friend->getFriend()->getCity()->getName() : null,
                    'longitude'    => null !== $friend->getFriend()->getCity() ? $friend->getFriend()->getCity()->getLongitude() : null,
                    'latitude'     => null !== $friend->getFriend()->getCity() ? $friend->getFriend()->getCity()->getLatitude() : null,
                ];
            }

            return $array;
        } else {
            return [
                'id'           => $data->getFriend()->getId(),
                'username'     => $data->getFriend()->getUsername(),
                'picture'      => $data->getFriend()->getPicture(),
                'street'       => $data->getFriend()->getStreet(),
                'streetNumber' => $data->getFriend()->getStreetNumber(),
                'job'          => null !== $data->getFriend()->getJob() ? $data->getFriend()->getJob()->getName() : null,
                'city'         => null !== $data->getFriend()->getCity() ? $data->getFriend()->getCity()->getName() : null,
                'longitude'    => null !== $data->getFriend()->getCity() ? $data->getFriend()->getCity()->getLongitude() : null,
                'latitude'     => null !== $data->getFriend()->getCity() ? $data->getFriend()->getCity()->getLatitude() : null,
            ];
        }
    }
}
