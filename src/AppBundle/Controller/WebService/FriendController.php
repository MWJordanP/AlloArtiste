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
        $token = $request->get('token');
        if (!empty($token)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getToken($token);
            if (null !== $user) {
                $friendManager = $this->get('app.manager.friend');
                $friends       = $friendManager->getByUser($user);

                return new JsonResponse([
                    'response' => $friendManager->convertArray($friends),
                    'error'    => null,
                    'status'   => true,
                ]);
            }

            return new JsonResponse([
                'response' => [],
                'error'    => $this->get('translator')->trans('error.user.not_found'),
                'status'   => false,
            ]);
        }

        return new JsonResponse([
            'response' => [],
            'error'    => $this->get('translator')->trans('error.user.token_empty'),
            'status'   => false,
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
                if (null === $friendManager->getByUserAndUserAdd($user, $userAdd)) {
                    $friendManager->create($user, $userAdd);
                    $friends = $friendManager->getByUser($user);

                    return new JsonResponse([
                        'response' => $friendManager->convertArray($friends),
                        'status'   => true,
                        'error'    => null,
                    ]);
                }

                return new JsonResponse([
                    'response' => [],
                    'error'    => $this->get('translator')->trans('error.friend.exist'),
                    'status'   => true,
                ]);
            }

            return new JsonResponse([
                'response' => [],
                'error'    => $this->get('translator')->trans('error.friend.user_or_contact_not_found'),
                'status'   => false,
            ]);
        }

        return new JsonResponse([
            'response' => [],
            'error'    => $this->get('translator')->trans('error.user.id_token_empty'),
            'status'   => false,
        ]);
    }
}
