<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/detail/artist", name="web_service_user_detail")
     */
    public function detailArtistAction(Request $request)
    {
        $token       = $request->get('token');
        $userManager = $this->get('app.manager.user');
        $user        = $userManager->getToken($token, 'ROLE_ARTIST');
        exit;
        return new JsonResponse($cityManager->convertArray($cities));
    }
}
