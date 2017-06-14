<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CityController
 *
 * @Route("/city")
 */
class CityController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/all", name="web_service_city_all")
     */
    public function allAction()
    {
        $cityManager = $this->get('app.manager.city');
        $cities      = $cityManager->getList();

        return new JsonResponse([
            'response' => $cityManager->convertArray($cities),
            'error'    => null,
            'status'   => true,
        ]);
    }
}
