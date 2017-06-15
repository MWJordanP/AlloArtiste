<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Picture;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Class PictureManager
 */
class PictureManager extends AbstractManager
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
        $this->repository = $entityManager->getRepository('AppBundle:Picture');
    }

    /**
     * @return Picture[]|array
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
     * @param User   $user
     * @param string $string
     *
     * @return Picture
     */
    public function create(User $user, $string)
    {
        $picture = new Picture();
        $picture
            ->setName($string)
            ->setUser($user);

        $this->save($picture);

        return $picture;
    }

    /**
     * @param integer $id
     *
     * @return Picture
     */
    public function getById($id)
    {
        $job = $this->repository->find($id);

        return $job;
    }

    /**
     * @param User $user
     *
     * @return Picture[]|array
     */
    public function getByUser(User $user)
    {
        $pictures = $this->repository->findBy(['user' => $user]);

        return $pictures;
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
            /** @var Picture $picture */
            foreach ($data as $picture) {
                $array[] = [
                    'id'   => $picture->getId(),
                    'name' => $picture->getName(),
                ];
            }

            return $array;
        } else {
            return [
                'id'   => $data->getId(),
                'name' => $data->getName(),
            ];
        }
    }
}
