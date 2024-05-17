<?php

namespace App\Controller;

use App\Entity\TenancyAgreements;
use App\Form\TenancyAgreementsType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\TenancyAgreementsRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/tenancy/agreements")
 */
class TenancyAgreementsController extends AbstractController
{
    /**
     * @Route("/", name="tenancy_agreements_index", methods={"GET"})
     */
    public function index(TenancyAgreementsRepository $tenancyAgreementsRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('tenancy_agreements/index.html.twig', [
            'tenancy_agreements' => $tenancyAgreementsRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tenancy_agreements_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TenancyAgreementsRepository $tenancyAgreementsRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Tenancy Agreement'
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
        $tenancyAgreement = new TenancyAgreements();
        $form = $this->createForm(TenancyAgreementsType::class, $tenancyAgreement,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $tenancyAgreement->getTenant()->getFullName();
            $tenancy_agreement_directory = $this->getParameter('financials_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Tenancy_Agreement_".$userFullName ."1." . $file->guessExtension();
                $file->move($tenancy_agreement_directory, $newFilename);
                $tenancyAgreement->setFile($newFilename);
            }
            $tenancyAgreementsRepository->add($tenancyAgreement, true);
            return $this->redirectToRoute('tenancy_agreements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tenancy_agreements/new.html.twig', [
            'tenancy_agreement' => $tenancyAgreement,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="tenancy_agreements_show", methods={"GET"})
     */
    public function show(TenancyAgreements $tenancyAgreement): Response
    {
        return $this->render('tenancy_agreements/show.html.twig', [
            'tenancy_agreement' => $tenancyAgreement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tenancy_agreements_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TenancyAgreements $tenancyAgreement, TenancyAgreementsRepository $tenancyAgreementsRepository, Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Tenancy Agreement'
        ]);
        $form = $this->createForm(TenancyAgreementsType::class, $tenancyAgreement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $tenancyAgreement->getTenant()->getFullName();
            $tenancy_agreement_directory = $this->getParameter('financials_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Tenancy_Agreement_".$userFullName ."1." . $file->guessExtension();
                $file->move($tenancy_agreement_directory, $newFilename);
                $tenancyAgreement->setFile($newFilename);
            }
            $tenancyAgreementsRepository->add($tenancyAgreement, true);
            return $this->redirectToRoute('tenancy_agreements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tenancy_agreements/edit.html.twig', [
            'tenancy_agreement' => $tenancyAgreement,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="tenancy_agreements_delete", methods={"POST"})
     */
    public function delete(Request $request, TenancyAgreements $tenancyAgreement, TenancyAgreementsRepository $tenancyAgreementsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tenancyAgreement->getId(), $request->request->get('_token'))) {
            $tenancyAgreementsRepository->remove($tenancyAgreement, true);
        }

        return $this->redirectToRoute('app_tenancy_agreements_index', [], Response::HTTP_SEE_OTHER);
    }
}
