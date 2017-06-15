<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JobController
 *
 * @Route("/tag")
 */
class TagController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/all", name="web_service_tag_all")
     */
    public function allAction()
    {
        $tagManager = $this->get('app.manager.tag');
        $tags       = $tagManager->getList();

        return new JsonResponse([
            'response' => $tagManager->convertArray($tags),
            'error'    => null,
            'status'   => true,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/add", name="web_service_tag_add")
     */
    public function addAction(Request $request)
    {
        $token = $request->request->get('token');
        $tag   = $request->request->get('tag');
        if (!empty($token) && is_string($token) && !empty($tag) && is_string($tag)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getToken($token);
            if (null !== $user) {
                $tagManager = $this->get('app.manager.tag');
                $tagManager->create($user, $tag);
                $tags = $tagManager->getByUser($user);

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
            'error'    => $this->get('translator')->trans('error.tag.token_tag_empty'),
            'status'   => false,
        ]);
    }
}
