<?php

namespace App\Controller;

use App\Entity\Cms;
use App\Form\CmsType;
use App\Repository\CmsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cms")
 * @Security("is_granted('ROLE_STAFF')")
 */
class CmsController extends AbstractController
{
    /**
     * @Route("/", name="cms_index", methods={"GET"})
     */
    public function index(CmsRepository $cmsRepository): Response
    {
        return $this->render('cms/index.html.twig', [
            'cms'=>$cmsRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="cms_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CmsRepository $cmsRepository): Response
    {
        $cms = new Cms();
        $form = $this->createForm(CmsType::class, $cms);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cmsRepository->add($cms, true);

            return $this->redirectToRoute('cms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cms/new.html.twig', [
            'cms' => $cms,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cms_show", methods={"GET"})
     */
    public function show(Cms $cms): Response
    {
        return $this->render('cms/show.html.twig', [
            'cms' => $cms,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cms_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cms $cms, CmsRepository $cmsRepository): Response
    {
        $form = $this->createForm(CmsType::class, $cms);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cmsRepository->add($cms, true);

            return $this->redirectToRoute('cms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cms/edit.html.twig', [
            'cms' => $cms,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="cms_delete", methods={"POST"})
     */
    public function delete(Request $request, Cms $cms, CmsRepository $cmsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cms->getId(), $request->request->get('_token'))) {
            $cmsRepository->remove($cms, true);
        }

        return $this->redirectToRoute('cms_index', [], Response::HTTP_SEE_OTHER);
    }
}
