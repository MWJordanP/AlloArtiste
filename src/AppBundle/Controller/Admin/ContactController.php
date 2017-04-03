<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @return Response
     *
     * @Route("/", name="admin_contact_index")
     */
    public function indexAction()
    {
        $contactManager = $this->get('app.manager.contact');
        $contacts       = $contactManager->getPaginateList();

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @param integer $id
     *
     * @return Response
     *
     * @Route("/{id}/show", name="admin_contact_show")
     */
    public function showAction($id)
    {
        $contactManager = $this->get('app.manager.contact');
        $contact        = $contactManager->getById($id);

        return $this->render('admin/contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }
}
