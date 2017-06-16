<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Slide;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class SlideManager
 */
class SlideManager extends AbstractManager
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
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
        $this->repository = $entityManager->getRepository('AppBundle:Slide');
    }

    /**
     * @return Slide[]|array
     */
    public function getList()
    {
        $slides = $this->repository->findAll();

        return $slides;
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
            /** @var Slide $slide */
            foreach ($data as $slide) {
                $array[] = [
                    'id'   => $slide->getPicture()->getId(),
                    'name' => $slide->getPicture()->getName(),
                ];
            }

            return $array;
        } else {
            return [
                'id'   => $data->getPicture()->getId(),
                'name' => $data->getPicture()->getName(),
            ];
        }
    }
}
