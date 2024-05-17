<?php

namespace App\Controller;

use App\Entity\DocumentHistory;
use App\Form\DocumentHistoryType;
use App\Repository\DocumentHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/document/history")
 */
class DocumentHistoryController extends AbstractController
{
    /**
     * @Route("/{clientId}", name="document_history_index", methods={"GET"},defaults={"clientId"=NUll})
     */
    public function index(request $request, $clientId, DocumentHistoryRepository $documentHistoryRepository): Response
    {
        $document_history = $documentHistoryRepository->findAll();
        if($clientId){
            $document_history = $documentHistoryRepository->findBy([
                'client'=>$clientId
            ]);
        }


        return $this->render('document_history/index.html.twig', [
            'document_histories' => $document_history
        ]);
    }

    /**
     * @Route("/new", name="document_history_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DocumentHistoryRepository $documentHistoryRepository): Response
    {
        $documentHistory = new DocumentHistory();
        $form = $this->createForm(DocumentHistoryType::class, $documentHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notes = $form['notes']->getData();
            $documentHistory->setNotes([$notes]);
            $documentHistoryRepository->add($documentHistory, true);

            return $this->redirectToRoute('document_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document_history/new.html.twig', [
            'document_history' => $documentHistory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_history_show", methods={"GET"})
     */
    public function show(DocumentHistory $documentHistory): Response
    {
        return $this->render('document_history/show.html.twig', [
            'document_history' => $documentHistory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_history_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DocumentHistory $documentHistory, DocumentHistoryRepository $documentHistoryRepository): Response
    {
        $form = $this->createForm(DocumentHistoryType::class, $documentHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $documentHistoryRepository->add($documentHistory, true);

            return $this->redirectToRoute('document_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('document_history/edit.html.twig', [
            'document_history' => $documentHistory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="document_history_delete", methods={"POST"})
     */
    public function delete(Request $request, DocumentHistory $documentHistory, DocumentHistoryRepository $documentHistoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $documentHistory->getId(), $request->request->get('_token'))) {
            $documentHistoryRepository->remove($documentHistory, true);
        }

        return $this->redirectToRoute('document_history_index', [], Response::HTTP_SEE_OTHER);
    }
}
