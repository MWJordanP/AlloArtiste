<?php

namespace AppBundle\Controller\WebService;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JobController
 *
 * @Route("/job")
 */
class JobController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/all", name="web_service_job_all")
     */
    public function allAction()
    {
        $jobManager = $this->get('app.manager.job');
        $jobs       = $jobManager->getList();

        return new JsonResponse($jobManager->convertArray($jobs));
    }
}
