<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="home_web_service")
     */
    public function indexAction()
    {
        return new JsonResponse('success');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/user", name="web_service_user_show")
     */
    public function userAction(Request $request)
    {
        $username = $request->get('username');

        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy([
            'username' => $username,
        ]);

        return new JsonResponse([
            'user'    => null === $user ? $user : $user->getUsername(),
            'request' => $request->attributes,
        ]);
    }
}
