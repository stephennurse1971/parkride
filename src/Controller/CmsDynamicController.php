<?php

namespace App\Controller;

use App\Entity\CmsDynamic;
use App\Form\CmsDynamicType;
use App\Repository\CmsDynamicRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cmsdynamic")
 * @Security("is_granted('ROLE_STAFF')")
 */
class CmsDynamicController extends AbstractController
{
    /**
     * @Route("/", name="cms_dynamic_index", methods={"GET"})
     */
    public function index(CmsDynamicRepository $cmsDynamicRepository): Response
    {
        return $this->render('cms_dynamic/index.html.twig', [
            'cms_dynamics' => $cmsDynamicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cms_dynamic_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CmsDynamicRepository $cmsDynamicRepository): Response
    {
        $cmsDynamic = new CmsDynamic();
        $form = $this->createForm(CmsDynamicType::class, $cmsDynamic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cmsDynamicRepository->add($cmsDynamic, true);

            return $this->redirectToRoute('cms_dynamic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cms_dynamic/new.html.twig', [
            'cms_dynamic' => $cmsDynamic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cms_dynamic_show", methods={"GET"})
     */
    public function show(CmsDynamic $cmsDynamic): Response
    {
        return $this->render('cms_dynamic/show.html.twig', [
            'cms_dynamic' => $cmsDynamic,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="cms_dynamic_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CmsDynamic $cmsDynamic, CmsDynamicRepository $cmsDynamicRepository): Response
    {
        $form = $this->createForm(CmsDynamicType::class, $cmsDynamic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('picture')) {
                $photo = $form->get('picture')->getData();
                if ($photo) {
                    $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $cmsDynamic->getArticlePage() . '.' . $photo->guessExtension();
                    $photo->move(
                        $this->getParameter('article_pictures_directory'),
                        $newFilename
                    );
                    $cmsDynamic->setPicture($newFilename);
                }
            }

            $cmsDynamicRepository->add($cmsDynamic, true);

            return $this->redirectToRoute('cms_dynamic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cms_dynamic/edit.html.twig', [
            'cms_dynamic' => $cmsDynamic,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cms_dynamic_delete", methods={"POST"})
     */
    public function delete(Request $request, CmsDynamic $cmsDynamic, CmsDynamicRepository $cmsDynamicRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cmsDynamic->getId(), $request->request->get('_token'))) {
            $cmsDynamicRepository->remove($cmsDynamic, true);
        }

        return $this->redirectToRoute('cms_dynamic_index', [], Response::HTTP_SEE_OTHER);
    }
}
