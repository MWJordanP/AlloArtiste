<?php

namespace AppBundle\Controller\WebService;

use AppBundle\Entity\User;
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

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/change-password", name="web_service_user_change_password")
     */
    public function changePasswordAction(Request $request)
    {
        $username    = $request->get('username');
        $userManager = $this->get('app.manager.user');
        /** @var User $user */
        $user = $userManager->userManager->findUserByUsernameOrEmail($username);
        if (null !== $user) {
            $password = $userManager->password($user);
            $mailer   = $this->get('mailer');
            $message  = \Swift_Message::newInstance()
                ->setSubject($this->get('translator')->trans('email.change_password.title'))
                ->setFrom($this->getParameter('mailer_sender_address'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'app/email/change_password.html.twig',
                        ['password' => $password]
                    ),
                    'text/html'
                );

            $mailer->send($message);

            return new JsonResponse([
                'status' => true,
            ]);
        }

        return new JsonResponse([
            'status' => false,
        ]);
    }

}