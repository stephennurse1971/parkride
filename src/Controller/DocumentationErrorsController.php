<?php

namespace App\Controller;

use App\Entity\DocumentationErrors;
use App\Form\DocumentationErrorsType;
use App\Repository\DocumentationErrorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/documentation/errors")
 */
class DocumentationErrorsController extends AbstractController
{
    /**
     * @Route("/index/{service}", name="documentation_errors_index", methods={"GET"})
     */
    public function index(string $service, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        $list_documents = ['Passport', 'Birth Marriage Death certificate', 'Financial Statement', 'Tenancy Agreement', 'Utility Bill', 'Employment Contract', 'Criminal Record Check', 'Medical', 'Health Insurance', 'School Attendance Certificate', 'Driving License'
        ];
        if ($service == 'All') {
            $documentation_errors = $documentationErrorsRepository->findAll();
        }
        if ($service != 'All'){
            $documentation_errors = $documentationErrorsRepository->findBy([
                'document'=>$service
            ]);
        }

        return $this->render('documentation_errors/index.html.twig', [
            'documentation_errors' => $documentation_errors,
            'list_of_documents'=>$list_documents

        ]);
    }

    /**
     * @Route("/new", name="documentation_errors_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        $documentationError = new DocumentationErrors();
        $form = $this->createForm(DocumentationErrorsType::class, $documentationError);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentationErrorsRepository->add($documentationError, true);

            return $this->redirectToRoute('documentation_errors_index', ['service'=>'All'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('documentation_errors/new.html.twig', [
            'documentation_error' => $documentationError,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="documentation_errors_show", methods={"GET"})
     */
    public function show(DocumentationErrors $documentationError): Response
    {
        return $this->render('documentation_errors/show.html.twig', [
            'documentation_error' => $documentationError,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="documentation_errors_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DocumentationErrors $documentationError, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        $form = $this->createForm(DocumentationErrorsType::class, $documentationError);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentationErrorsRepository->add($documentationError, true);
            return $this->redirectToRoute('documentation_errors_index', ['service'=>'All'], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('documentation_errors/edit.html.twig', [
            'documentation_error' => $documentationError,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="documentation_errors_delete", methods={"POST"})
     */
    public function delete(Request $request, DocumentationErrors $documentationError, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $documentationError->getId(), $request->request->get('_token'))) {
            $documentationErrorsRepository->remove($documentationError, true);
        }

        return $this->redirectToRoute('documentation_errors_index', [], Response::HTTP_SEE_OTHER);
    }
}
