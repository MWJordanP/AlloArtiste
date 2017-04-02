<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="admin")
     */
    public function indexAction()
    {
        return $this->render('admin/default/index.html.twig');
    }
}
