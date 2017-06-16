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
     * @Route("/detail", name="web_service_user_detail")
     */
    public function detailAction(Request $request)
    {
        $id = $request->get('id');
        if (!empty($id)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getById($id);
            if (null !== $user) {
                return new JsonResponse([
                    'response' => $userManager->convertArray($user),
                    'error'    => null,
                    'status'   => true,
                ]);
            }

            return new JsonResponse([
                'response' => null,
                'error'    => $this->get('translator')->trans('error.user.not_found'),
                'status'   => false,
            ]);
        }

        return new JsonResponse([
            'response' => null,
            'error'    => $this->get('translator')->trans('error.user.id_empty'),
            'status'   => false,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/add/image", name="web_service_user_add_image")
     */
    public function addImageAction(Request $request)
    {
        $token = $request->request->get('token');
        $image = $request->request->get('image');
        if (!empty($token) && is_string($token) && !empty($image) && is_string($image)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getToken($token);
            if (null !== $user) {
                $user->setPicture($image);
                $userManager->save($user);

                return new JsonResponse([
                    'response' => $userManager->convertArray($user),
                    'status'   => true,
                    'error'    => null,
                ]);
            }

            return new JsonResponse([
                'response' => null,
                'error'    => $this->get('translator')->trans('error.user.not_found'),
                'status'   => false,
            ]);
        }

        return new JsonResponse([
            'response' => null,
            'error'    => $this->get('translator')->trans('error.user.token_image_empty'),
            'status'   => false,
        ]);
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
                'response' => null,
                'error'    => null,
                'status'   => true,
            ]);
        }

        return new JsonResponse([
            'response' => null,
            'error'    => $this->get('translator')->trans('error.user.not_found'),
            'status'   => false,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/edit-profile", name="web_service_user_edit_profile")
     */
    public function updateProfileAction(Request $request)
    {
        $token       = $request->request->get('token');
        $userManager = $this->get('app.manager.user');
        $user        = $userManager->getToken($token);
        if (null !== $user) {
            $check = $userManager->updateProfile($request, $user);
            if ($check === true) {
                return new JsonResponse([
                    'response' => $userManager->convertArray($user),
                    'error'    => null,
                    'status'   => true,
                ]);
            }

            return new JsonResponse([
                'response' => null,
                'error'    => $check,
                'status'   => false,
            ]);
        }

        return new JsonResponse([
            'response' => null,
            'error'    => $this->get('translator')->trans('error.user.not_found'),
            'status'   => false,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/register", name="web_service_user_register")
     */
    public function registerArtist(Request $request)
    {
        $username  = $request->request->get('username');
        $password  = $request->request->get('password');
        $email     = $request->request->get('email');
        $firstName = $request->request->get('firstName');
        $lastName  = $request->request->get('lastName');

        if (!empty($username) && !empty($password) && !empty($email) && !empty($firstName) && !empty($lastName)) {
            $userManager = $this->get('app.manager.user');
            $user        = new User();
            $user
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setUsername($username)
                ->setPlainPassword($password)
                ->setEmail($email)
                ->setEnabled(true);

            try {
                $userManager->userManager->updateUser($user);

                return new JsonResponse([
                    'response' => $userManager->convertArray($user),
                    'status'   => true,
                    'error'    => null,
                ]);
            } catch (\Exception $exception) {
                return new JsonResponse([
                    'response' => null,
                    'error'    => $exception->getMessage(),
                    'status'   => false,
                ]);
            }
        }

        return new JsonResponse([
            'response' => null,
            'error'    => $this->get('translator')->trans('error.user.register_not_found'),
            'status'   => false,
        ]);
    }
}
