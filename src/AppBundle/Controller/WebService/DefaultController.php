<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if (is_string($username)) {
            $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy([
                'username' => $username,
            ]);

            if (null !== $user) {
                return new JsonResponse([
                    'user'   => [
                        'id'       => $user->getId(),
                        'username' => $user->getUsername(),
                    ],
                    'status' => 'success',
                ]);
            } else {
                return new JsonResponse([
                    'user'   => null,
                    'status' => 'error',
                ]);
            }
        }

        throw new NotFoundHttpException('Username not string');
    }
}
