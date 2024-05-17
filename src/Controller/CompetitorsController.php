<?php

namespace App\Controller;

use App\Entity\Competitors;
use App\Form\CompetitorsType;
use App\Repository\CompetitorServiceRepository;
use App\Repository\CompetitorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competitors")
 */
class CompetitorsController extends AbstractController
{
    /**
     * @Route("/", name="competitors_index", methods={"GET"})
     */
    public function index(CompetitorsRepository $competitorsRepository, CompetitorServiceRepository $competitorServiceRepository): Response
    {
        return $this->render('competitors/index.html.twig', [
            'competitors' => $competitorsRepository->findAll(),
            'competitor_services' => $competitorServiceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="competitors_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompetitorsRepository $competitorsRepository): Response
    {
        $competitor = new Competitors();
        $form = $this->createForm(CompetitorsType::class, $competitor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitorsRepository->add($competitor, true);

            return $this->redirectToRoute('competitors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competitors/new.html.twig', [
            'competitor' => $competitor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="competitors_show", methods={"GET"})
     */
    public function show(Competitors $competitor): Response
    {
        return $this->render('competitors/show.html.twig', [
            'competitor' => $competitor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competitors_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Competitors $competitor, CompetitorsRepository $competitorsRepository): Response
    {
        $form = $this->createForm(CompetitorsType::class, $competitor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitorsRepository->add($competitor, true);

            return $this->redirectToRoute('competitors_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competitors/edit.html.twig', [
            'competitor' => $competitor,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="competitors_delete", methods={"POST"})
     */
    public function delete(Request $request, Competitors $competitor, CompetitorsRepository $competitorsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competitor->getId(), $request->request->get('_token'))) {
            $competitorsRepository->remove($competitor, true);
        }

        return $this->redirectToRoute('competitors_index', [], Response::HTTP_SEE_OTHER);
    }
}
