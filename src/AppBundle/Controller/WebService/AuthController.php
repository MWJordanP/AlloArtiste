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
        $userManager     = $this->get('fos_user.user_manager');
        $user            = $userManager->findUserByUsernameOrEmail($username);
        if (null !== $user) {
            $password = $this->get('security.password_encoder')->isPasswordValid($user, $passwordRequest);
            if ($password) {
                return new JsonResponse([
                    'lastUsername' => $username,
                    'error'        => null,
                ]);
            } else {
                return new JsonResponse([
                    'lastUsername' => $username,
                    'error'        => 'Password not valid',
                ]);
            }
        }

        return new JsonResponse([
            'lastUsername' => $username,
            'error'        => 'User not exist',
        ]);
    }
}
