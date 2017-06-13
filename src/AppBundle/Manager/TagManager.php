<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Tag;
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
                    'Id'   => $tag->getId(),
                    'Name' => $tag->getName(),
                ];
            }

            return $array;
        } else {
            return [
                'Id'   => $data->getId(),
                'Name' => $data->getName(),
            ];
        }
    }
}
