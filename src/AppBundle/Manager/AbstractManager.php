<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Class AbstractManager
 */
class AbstractManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var EntityManager
     */
    protected $requestStack;

    /**
     * AbstractManager constructor.
     *
     * @param EntityManager $entityManager
     * @param Paginator     $paginator
     * @param RequestStack  $requestStack
     */
    public function __construct(EntityManager $entityManager, Paginator $paginator, RequestStack $requestStack)
    {
        $this->em           = $entityManager;
        $this->paginator    = $paginator;
        $this->requestStack = $requestStack;
    }

    /**
     * @param object $entity
     *
     * @return mixed
     */
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    /**
     * @param object $entity
     */
    public function remove($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();
    }

    /**
     * @param array|ArrayCollection $list
     * @param integer               $limit
     *
     * @return PaginationInterface
     */
    public function paginate($list, $limit = 10)
    {
        $list = $this->paginator->paginate(
            $list,
            $this->requestStack->getCurrentRequest()->query->getInt('page', 1),
            $limit
        );

        return $list;
    }
}
