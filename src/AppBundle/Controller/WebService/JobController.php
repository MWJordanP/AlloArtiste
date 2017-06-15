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

        return new JsonResponse([
            'response' => $jobManager->convertArray($jobs),
            'error'    => null,
            'status'   => true,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     *
     * @Route("/add", name="web_service_job_add")
     */
    public function addTag(Request $request)
    {
        $token = $request->request->get('token');
        $job   = $request->request->get('id');
        if (!empty($token) && is_string($token) && !empty($job) && is_string($job)) {
            $userManager = $this->get('app.manager.user');
            $user        = $userManager->getToken($token);
            $jobManager  = $this->get('app.manager.job');
            $job         = $jobManager->getById($job);
            if (null !== $user && null !== $job) {
                $user->setJob($job);
                $userManager->userManager->updateUser($user);

                return new JsonResponse([
                    'response' => $userManager->convertArray($user),
                    'error'    => null,
                    'status'   => true,
                ]);
            }

            return new JsonResponse([
                'response' => null,
                'error'    => $this->get('translator')->trans('error.job.user_or_job_empty'),
                'status'   => false,
            ]);
        }

        return new JsonResponse([
            'response' => null,
            'error'    => $this->get('translator')->trans('error.job.token_job_empty'),
            'status'   => false,
        ]);
    }
}
