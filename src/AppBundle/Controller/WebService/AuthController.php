<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthController
 *
 * @Route("/auth")
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/login", name="web_service_auth_login")
     */
    public function loginAction(Request $request)
    {
        $username        = $request->get('username');
        $passwordRequest = $request->get('password');
        $userManager     = $this->get('app.manager.user');
        $user            = $userManager->userManager->findUserByUsernameOrEmail($username);
        if (null !== $user) {
            $password = $this->get('security.password_encoder')->isPasswordValid($user, $passwordRequest);
            if ($password) {
                return new JsonResponse([
                    'response' => $userManager->convertArray($user),
                    'status'   => true,
                    'error'    => null,
                ]);
            } else {
                return new JsonResponse([
                    'error'    => $this->get('translator')->trans('error.auth.password_not_valid'),
                    'response' => null,
                    'status'   => false,
                ]);
            }
        }

        return new JsonResponse([
            'response' => null,
            'status'   => false,
            'error'    => $this->get('translator')->trans('error.user.not_found'),
        ]);
    }
}
