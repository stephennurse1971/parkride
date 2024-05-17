<?php

namespace App\Controller;

use App\Entity\DocumentGuidelines;
use App\Form\DocumentGuidelinesType;
use App\Repository\DocumentGuidelinesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/document/guidelines")
 */
class DocumentGuidelinesController extends AbstractController
{
    /**
     * @Route("/", name="document_guidelines_index", methods={"GET"})
     */
    public function index(DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        return $this->render('document_guidelines/index.html.twig', [
            'document_guidelines' => $documentGuidelinesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="document_guidelines_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $documentGuideline = new DocumentGuidelines();
        $form = $this->createForm(DocumentGuidelinesType::class, $documentGuideline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentGuidelinesRepository->add($documentGuideline, true);

            return $this->redirectToRoute('document_guidelines_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document_guidelines/new.html.twig', [
            'document_guideline' => $documentGuideline,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_guidelines_show", methods={"GET"})
     */
    public function show(DocumentGuidelines $documentGuideline): Response
    {
        return $this->render('document_guidelines/show.html.twig', [
            'document_guideline' => $documentGuideline,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_guidelines_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DocumentGuidelines $documentGuideline, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $form = $this->createForm(DocumentGuidelinesType::class, $documentGuideline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentGuidelinesRepository->add($documentGuideline, true);

            return $this->redirectToRoute('document_guidelines_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document_guidelines/edit.html.twig', [
            'document_guideline' => $documentGuideline,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_guidelines_delete", methods={"POST"})
     */
    public function delete(Request $request, DocumentGuidelines $documentGuideline, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$documentGuideline->getId(), $request->request->get('_token'))) {
            $documentGuidelinesRepository->remove($documentGuideline, true);
        }

        return $this->redirectToRoute('document_guidelines_index', [], Response::HTTP_SEE_OTHER);
    }
}
