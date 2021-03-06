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
        $userManager  = $this->get('app.manager.user');
        $users        = $userManager->repository->findBy([], ['id' => 'DESC'], 8);
        $slideManager = $this->get('app.manager.slide');
        $slides       = $slideManager->getList();

        return new JsonResponse([
            'response' => [
                'users'  => $userManager->convertArray($users),
                'slides' => $slideManager->convertArray($slides),
            ],
            'error'    => null,
            'status'   => true,
        ]);
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
                'username' => $username,
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
                'username' => $username,
            ]);

            if (null !== $user) {
                return new JsonResponse([
                    'Username'  => $user->getUsername(),
                    'FirstName' => $user->getFirstName(),
                    'LastName'  => $user->getLastName(),
                ]);
            }
        }

        return new JsonResponse([
            'Username'  => $username,
            'FirstName' => null,
            'LastName'  => null,
        ]);
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

        return new JsonResponse($data);
    }
}
