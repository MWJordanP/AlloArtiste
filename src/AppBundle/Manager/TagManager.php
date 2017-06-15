<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Tag;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TagManager
 */
class TagManager extends AbstractManager
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
        $this->repository = $entityManager->getRepository('AppBundle:Tag');
    }

    /**
     * @return Tag[]|array
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
     *
     * @return Tag[]|array
     */
    public function getByUser(User $user)
    {
        $tags = $this->repository->findBy(['users' => $user]);

        return $tags;
    }

    /**
     * @param integer $id
     *
     * @return Tag
     */
    public function getById($id)
    {
        $tag = $this->repository->find($id);
        if (null === $tag) {
            throw new NotFoundHttpException('Tag not found');
        }

        return $tag;
    }

    /**
     * @param User   $user
     * @param string $string
     *
     * @return Tag
     */
    public function create(User $user, $string)
    {
        $tag = new Tag();
        $tag
            ->setName($string)
            ->getUsers()->add($user);

        $this->save($tag);

        return $tag;
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
            /** @var Tag $tag */
            foreach ($data as $tag) {
                $array[] = [
                    'id'   => $tag->getId(),
                    'name' => $tag->getName(),
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
