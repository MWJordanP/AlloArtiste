<?php

namespace AppBundle\Controller\WebService;

use AppBundle\Entity\User;
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
     * @Route("/user-test", name="web_service_user_show")
     */
    public function userAction(Request $request)
    {
        $username = $request->get('username');

        if (is_string($username)) {
            $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy([
                'Username' => $username,
            ]);

            if (null !== $user) {
                return new JsonResponse([
                    'Username' => $user->getUsername(),
                ]);
            } else {
                return new JsonResponse([
                    'Username' => 'Pas trouvé',
                ]);
            }
        }

        throw new NotFoundHttpException('Username not string');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/completed-user-test", name="web_service_user_completed")
     */
    public function completedUserTestAction(Request $request)
    {
        $username = $request->get('username');

        if (is_string($username)) {
            $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findOneBy([
                'Username' => $username,
            ]);

            if (null !== $user) {
                return new JsonResponse([
                    'Username'  => $user->getUsername(),
                    'FirstName' => $user->getFirstName(),
                    'FastName'  => $user->getLastName(),
                ]);
            } else {
                return new JsonResponse([
                    'Username'  => null,
                    'FirstName' => null,
                    'FastName'  => null,
                ]);
            }
        }

        throw new NotFoundHttpException('Username not string');
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/list-user-test", name="web_service_user_list")
     */
    public function listUserTestAction(Request $request)
    {
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();

        $data = [];
        /** @var User $user */
        foreach ($users as $user) {
            $data[] = [
                'Username'  => $user->getUsername(),
                'FirstName' => $user->getFirstName(),
                'LastName'  => $user->getLastName(),
            ];
        }

        return new JsonResponse([
            'users' => $data,
        ]);
    }
}
