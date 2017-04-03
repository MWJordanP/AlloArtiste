<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Controller\Traits\FlashTrait;
use AppBundle\Entity\Job;
use AppBundle\Form\Type\JobType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class JobController
 *
 * @Route("/job")
 */
class JobController extends Controller
{
    use FlashTrait;

    /**
     * @return Response
     *
     * @Route("/", name="admin_job_index")
     */
    public function indexAction()
    {
        $jobManager = $this->get('app.manager.job');
        $jobs       = $jobManager->getPaginateList();

        return $this->render('admin/job/index.html.twig', [
            'jobs' => $jobs,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/create", name="admin_job_create")
     */
    public function createAction(Request $request)
    {
        $jobManager = $this->get('app.manager.job');
        $job        = new Job();
        $form       = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $jobManager->save($job);
                $this->addFlash('success', 'flashes.admin.job.create.success');

                return $this->redirectToRoute('admin_job_index');
            } catch (\Exception $exception) {
                $this->addFlash('danger', 'flashes.admin.error');
            }
        }

        return $this->render('admin/job/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param integer $id
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="admin_job_edit")
     */
    public function editAction(Request $request, $id)
    {
        $jobManager = $this->get('app.manager.job');
        $job        = $jobManager->getById($id);
        $form       = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $jobManager->save($job);
                $this->addFlash('success', 'flashes.admin.job.edit.success');

                return $this->redirectToRoute('admin_job_index');
            } catch (\Exception $exception) {
                $this->addFlash('danger', 'flashes.admin.error');
            }
        }

        return $this->render('admin/job/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
