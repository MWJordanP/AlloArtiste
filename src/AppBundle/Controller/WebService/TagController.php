<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return new JsonResponse($tagManager->convertArray($tags));
    }
}
