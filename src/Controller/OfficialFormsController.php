<?php

namespace App\Controller;

use App\Entity\OfficialForms;
use App\Entity\Passports;
use App\Form\OfficialFormsType;
use App\Repository\OfficialFormsRepository;
use App\Repository\PassportsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/official/forms")
 */
class OfficialFormsController extends AbstractController
{
    /**
     * @Route("/", name="official_forms_index", methods={"GET"})
     */
    public function index(OfficialFormsRepository $officialFormsRepository): Response
    {
        return $this->render('official_forms/index.html.twig', [
            'official_forms' => $officialFormsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="official_forms_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OfficialFormsRepository $officialFormsRepository): Response
    {
        $officialForm = new OfficialForms();
        $form = $this->createForm(OfficialFormsType::class, $officialForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $officialFormsRepository->add($officialForm, true);

            return $this->redirectToRoute('official_forms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('official_forms/new.html.twig', [
            'official_form' => $officialForm,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="official_forms_show", methods={"GET"})
     */
    public function show(OfficialForms $officialForm): Response
    {
        return $this->render('official_forms/show.html.twig', [
            'official_form' => $officialForm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="official_forms_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OfficialForms $officialForm, OfficialFormsRepository $officialFormsRepository): Response
    {
        $form = $this->createForm(OfficialFormsType::class, $officialForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formName = $officialForm->getName();
            $official_form_directory = $this->getParameter('official_form_attachments_directory');
            $file = $form->get('file')->getData();

            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Official_form_" . $formName . $file->guessExtension();
                $file->move($official_form_directory, $newFilename);
                $officialForm->setFile($newFilename);
            }

            $officialFormsRepository->add($officialForm, true);

            return $this->redirectToRoute('official_forms_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('official_forms/edit.html.twig', ['official_form' => $officialForm,
            'form' => $form,]);
    }

    /**
     * @Route("/{id}", name="official_forms_delete", methods={"POST"})
     */
    public function delete(Request $request, OfficialForms $officialForm, OfficialFormsRepository $officialFormsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $officialForm->getId(), $request->request->get('_token'))) {
            $officialFormsRepository->remove($officialForm, true);
        }

        return $this->redirectToRoute('official_forms_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/delete/official_form/{id}", name="official_form_delete_uploaded_file", methods={"GET"})
     */
    public function deleteUploadedFile(Request $request, OfficialForms $officialForms, OfficialFormsRepository $officialFormsRepository): Response
    {
        $referer = $request->headers->get('Referer');
        $officialForms->setFile(null);
        $officialFormsRepository->add($officialForms, true);
        return $this->redirect($referer);
    }


}
