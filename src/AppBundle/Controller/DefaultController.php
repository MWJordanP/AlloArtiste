<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $userManager = $this->get('app.manager.user');
        $users       = $userManager->userManager->findUsers();

        return $this->render('app/default/index.html.twig', [
            'users' => $users,
        ]);
    }
}
