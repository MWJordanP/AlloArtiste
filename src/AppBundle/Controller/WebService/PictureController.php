<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PictureController
 *
 * @Route("/picture")
 */
class PictureController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/add", name="web_service_picture_add")
     */
    public function addAction(Request $request)
    {
        $token   = $request->request->get('token');
        $picture = $request->request->get('picture');
        if (!empty($token) && is_string($token) && !empty($picture) && is_string($picture)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getToken($token);
            if (null !== $user) {
                $pictureManager = $this->get('app.manager.picture');
                $pictureManager->create($user, $picture);

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
            'error'    => $this->get('translator')->trans('error.picture.token_picture_empty'),
            'status'   => false,
        ]);
    }
}
