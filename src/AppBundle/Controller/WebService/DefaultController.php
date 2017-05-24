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
        $json = $request->get('json');

        $decode = json_decode($json, true);

        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy([
            'username' => $decode['username'],
        ]);

        return new JsonResponse([
            'user' => null === $user ? 'La valeur envoyé est : '.$json : 'GG le nom de l\'utilisateur à été trouvé'.$user->getUsername(),
        ]);
    }
}
