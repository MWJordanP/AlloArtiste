<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FriendController
 *
 * @Route("/friend")
 */
class FriendController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/contact", name="web_service_friend_contact")
     */
    public function contactAction(Request $request)
    {
        $token       = $request->get('token');
        $userManager = $this->get('app.manager.user');
        $user        = $userManager->getToken($token, 'ROLE_ARTIST');
        if (null !== $user) {
            $friendManager = $this->get('app.manager.friend');
            $friends       = $friendManager->getByUser($user);

            return new JsonResponse($friendManager->convertArray($friends));
        }

        return new JsonResponse([
            'error'  => 'User not found',
            'status' => false,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/add", name="web_service_friend_add")
     */
    public function addAction(Request $request)
    {
        $token = $request->get('token');
        $id    = $request->get('id');
        if (!empty($token) && !empty($id)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getToken($token);
            $userAdd     = $userManager->getById($id);
            if (null !== $user && null !== $userAdd) {
                $friendManager = $this->get('app.manager.friend');
                $friendManager->create($user, $userAdd);
                $friends = $friendManager->getByUser($user);

                return new JsonResponse([
                    'contacts' => $friendManager->convertArray($friends),
                    'status'   => true,
                ]);
            }

            return new JsonResponse([
                'error'  => 'User or contact not found',
                'status' => false,
            ]);
        }

        return new JsonResponse([
            'error'  => 'Id or token is empty',
            'status' => false,
        ]);
    }
}
