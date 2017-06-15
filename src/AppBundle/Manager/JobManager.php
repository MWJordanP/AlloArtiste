<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Job;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class JobManager
 */
class JobManager extends AbstractManager
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
        $this->repository = $entityManager->getRepository('AppBundle:Job');
    }

    /**
     * @return Job[]|array
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
     * @return Job
     */
    public function getById($id)
    {
        $job = $this->repository->find($id);

        return $job;
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
            /** @var Job $job */
            foreach ($data as $job) {
                $array[] = [
                    'Id'   => $job->getId(),
                    'Name' => $job->getName(),
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
