<?php

namespace App\Controller;

use App\Entity\EmailTemplates;
use App\Entity\ServicesOffered;
use App\Form\EmailTemplatesType;
use App\Repository\EmailTemplatesRepository;
use App\Repository\ServicesOfferedRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/email/templates")
 * @Security("is_granted('ROLE_STAFF')")
 */
class EmailTemplatesController extends AbstractController
{
    /**
     * @Route("/index/{service}", name="email_templates_index", methods={"GET"},defaults={"service"="All"})
     */
    public function index(Request $request, string $service, EmailTemplatesRepository $emailTemplatesRepository, ServicesOfferedRepository $servicesOfferedRepository): Response
    {
        $servicesOffered = $servicesOfferedRepository->findAll();
        if ($service == 'All') {
            return $this->render('email_templates/index.html.twig', [
                'email_templates' => $emailTemplatesRepository->findAll(),
                'services' => $servicesOffered,
                'selected_service' => 'All'
            ]);
        }
        $serviceId = $servicesOfferedRepository->findOneBy([
            'serviceOffered' => $service
        ]);
        return $this->render('email_templates/index.html.twig', [
            'email_templates' => $emailTemplatesRepository->findBy([
                'service' => $serviceId
            ]),
            'services' => $servicesOffered,
            'selected_service' => $service,
        ]);

    }

    /**
     * @Route("/new", name="email_templates_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EmailTemplatesRepository $emailTemplatesRepository): Response
    {
        $emailTemplate = new EmailTemplates();
        $form = $this->createForm(EmailTemplatesType::class, $emailTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailTemplatesRepository->add($emailTemplate, true);
            return $this->redirectToRoute('email_templates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('email_templates/new.html.twig', [
            'email_template' => $emailTemplate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="email_templates_show", methods={"GET"})
     */
    public function show(EmailTemplates $emailTemplate): Response
    {
        return $this->render('email_templates/show.html.twig', [
            'email_template' => $emailTemplate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="email_templates_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EmailTemplates $emailTemplate, EmailTemplatesRepository $emailTemplatesRepository): Response
    {
        $form = $this->createForm(EmailTemplatesType::class, $emailTemplate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailTemplatesRepository->add($emailTemplate, true);

            return $this->redirectToRoute('email_templates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('email_templates/edit.html.twig', [
            'email_template' => $emailTemplate,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="email_templates_delete", methods={"POST"})
     */
    public function delete(Request $request, EmailTemplates $emailTemplate, EmailTemplatesRepository $emailTemplatesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $emailTemplate->getId(), $request->request->get('_token'))) {
            $emailTemplatesRepository->remove($emailTemplate, true);
        }

        return $this->redirectToRoute('email_templates_index', [], Response::HTTP_SEE_OTHER);
    }
}
