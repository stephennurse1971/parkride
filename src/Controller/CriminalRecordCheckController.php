<?php

namespace App\Controller;

use App\Entity\CriminalRecordCheck;
use App\Form\CriminalRecordCheckType;
use App\Repository\CriminalRecordCheckRepository;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/criminal/record/check")
 */
class CriminalRecordCheckController extends AbstractController
{
    /**
     * @Route("/", name="criminal_record_check_index", methods={"GET"})
     */
    public function index(CriminalRecordCheckRepository $criminalRecordCheckRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('criminal_record_check/index.html.twig', [
            'criminal_record_checks' => $criminalRecordCheckRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="criminal_record_check_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CriminalRecordCheckRepository $criminalRecordCheckRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Criminal Record Check'
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
        $criminalRecordCheck = new CriminalRecordCheck();
        $form = $this->createForm(CriminalRecordCheckType::class, $criminalRecordCheck,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $criminalRecordCheck->getApplicant()->getFullName();
            $criminal_record_check_directory = $this->getParameter('criminal_record_check_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Criminal_Record_Check_".$userFullName .".". $file->guessExtension();
                $file->move($criminal_record_check_directory, $newFilename);
                $criminalRecordCheck->setFile($newFilename);
            }

            $criminalRecordCheckRepository->add($criminalRecordCheck, true);

            return $this->redirectToRoute('criminal_record_check_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('criminal_record_check/new.html.twig', [
            'criminal_record_check' => $criminalRecordCheck,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="criminal_record_check_show", methods={"GET"})
     */
    public function show(CriminalRecordCheck $criminalRecordCheck): Response
    {
        return $this->render('criminal_record_check/show.html.twig', [
            'criminal_record_check' => $criminalRecordCheck,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="criminal_record_check_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request,CriminalRecordCheck $criminalRecordCheck, CriminalRecordCheckRepository $criminalRecordCheckRepository, Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $oldCriminalRecordCheck = clone $criminalRecordCheck;
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Criminal Record Check'
        ]);
        $form = $this->createForm(CriminalRecordCheckType::class, $criminalRecordCheck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $criminalRecordCheckRepository->add($criminalRecordCheck, true);


            $changes_count = $auditTracker->update($oldCriminalRecordCheck, $criminalRecordCheck, 'criminal record check', $security->getUser(), $criminalRecordCheck->getApplicant());
            if ($changes_count > 0 && $criminalRecordCheck->getApplicant() == $security->getUser()) {
                $criminalRecordCheck->setReviewed('Pending')
                    ->setReviewedBy(null)
                    ->setReviewedDate(null);
                $criminalRecordCheckRepository->add($criminalRecordCheck, true);
            }

            return $this->redirectToRoute('criminal_record_check_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('criminal_record_check/edit.html.twig', [
            'criminal_record_check' => $criminalRecordCheck,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="criminal_record_check_delete", methods={"POST"})
     */
    public function delete(Request $request, CriminalRecordCheck $criminalRecordCheck, CriminalRecordCheckRepository $criminalRecordCheckRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$criminalRecordCheck->getId(), $request->request->get('_token'))) {
            $criminalRecordCheckRepository->remove($criminalRecordCheck, true);
        }

        return $this->redirectToRoute('criminal_record_check_index', [], Response::HTTP_SEE_OTHER);
    }
}
