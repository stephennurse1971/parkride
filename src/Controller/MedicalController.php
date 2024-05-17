<?php

namespace App\Controller;

use App\Entity\Medical;
use App\Form\MedicalType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\MedicalRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/medical")
 */
class MedicalController extends AbstractController
{
    /**
     * @Route("/", name="medical_index", methods={"GET"})
     */
    public function index(MedicalRepository $medicalRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('medical/index.html.twig', [
            'medicals' => $medicalRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="medical_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MedicalRepository $medicalRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Medical'
        ]);
        $clients = $userRepository->findAll();
        $reviewed_By = [];
        foreach ($userRepository->findAll() as $client){
            if(in_array('ROLE_STAFF',$client->getRoles())){
                $reviewed_By[] = $client;
            }
        }
        if($request->query->get('client')){
            $client_name = $request->query->get('client');
            $client_name = explode(' ',$client_name);
            $first_name = $client_name[0];
            $last_name = $client_name[1];
            $clients = $userRepository->findBy(['firstName'=>$first_name,'lastName'=>$last_name]);
        }
        $medical = new Medical();
        $form = $this->createForm(MedicalType::class, $medical,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $medical->getPatient()->getFullName();
            $medicals_directory = $this->getParameter('medicals_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Medical_".$userFullName ."1." . $file->guessExtension();
                $file->move($medicals_directory, $newFilename);
                $medical->setFile($newFilename);
            }

            $medicalRepository->add($medical, true);

            return $this->redirectToRoute('medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medical/new.html.twig', [
            'medical' => $medical,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="medical_show", methods={"GET"})
     */
    public function show(Medical $medical): Response
    {
        return $this->render('medical/show.html.twig', [
            'medical' => $medical,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="medical_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Medical $medical, MedicalRepository $medicalRepository,Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Medical'
        ]);
        $form = $this->createForm(MedicalType::class, $medical);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicalRepository->add($medical, true);

            return $this->redirectToRoute('medical_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medical/edit.html.twig', [
            'medical' => $medical,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="medical_delete", methods={"POST"})
     */
    public function delete(Request $request, Medical $medical, MedicalRepository $medicalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medical->getId(), $request->request->get('_token'))) {
            $medicalRepository->remove($medical, true);
        }

        return $this->redirectToRoute('medical_index', [], Response::HTTP_SEE_OTHER);
    }
}
