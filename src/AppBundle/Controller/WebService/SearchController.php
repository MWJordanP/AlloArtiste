<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SearchController
 *
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/", name="web_service_search")
     */
    public function searchAction(Request $request)
    {
        $city        = $request->request->get('city');
        $job         = $request->request->get('job');
        $tag         = $request->request->get('tag');
        $userManager = $this->get('app.manager.user');
        $users       = $userManager->search($city, $job, $tag);

        return new JsonResponse([
            'response' => $userManager->convertArraySearch($users),
            'error'    => null,
            'status'   => true,
        ]);
    }
}
