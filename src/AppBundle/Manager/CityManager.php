<?php

namespace AppBundle\Manager;

use AppBundle\Entity\City;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CityManager
 */
class CityManager extends AbstractManager
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
        $this->repository = $entityManager->getRepository('AppBundle:City');
    }

    /**
     * @return City[]|array
     */
    public function getList()
    {
        return $this->repository->findBy([], ['id' => 'ASC'], 99);
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
     * @return City
     */
    public function getById($id)
    {
        $city = $this->repository->find($id);
        if (null === $city) {
            throw new NotFoundHttpException('City not found');
        }

        return $city;
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
            /** @var City $city */
            foreach ($data as $city) {
                $array[] = [
                    'Id'         => $city->getId(),
                    'Name'       => $city->getName(),
                    'SimpleName' => $city->getSimpleName(),
                    'ZipCode'    => $city->getZipCode(),
                    'Latitude'   => $city->getLatitude(),
                    'Longitude'  => $city->getLatitude(),
                ];
            }

            return $array;
        } else {
            return [
                'Id'         => $data->getId(),
                'Name'       => $data->getName(),
                'SimpleName' => $data->getSimpleName(),
                'ZipCode'    => $data->getZipCode(),
                'Latitude'   => $data->getLatitude(),
                'Longitude'  => $data->getLatitude(),
            ];
        }
    }
}
