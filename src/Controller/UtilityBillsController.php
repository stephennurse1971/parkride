<?php

namespace App\Controller;

use App\Entity\UtilityBills;
use App\Form\UtilityBillsType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\UserRepository;
use App\Repository\UtilityBillsRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/utility/bills")
 */
class UtilityBillsController extends AbstractController
{
    /**
     * @Route("/", name="utility_bills_index", methods={"GET"})
     */
    public function index(UtilityBillsRepository $utilityBillsRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('utility_bills/index.html.twig', [
            'utility_bills' => $utilityBillsRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="utility_bills_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UtilityBillsRepository $utilityBillsRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Utility Bill'
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
        $utilityBill = new UtilityBills();
        $form = $this->createForm(UtilityBillsType::class, $utilityBill,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $utilityBill->getCustomer()->getFullName();
            $utility_bills_directory = $this->getParameter('financials_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Financial_Statement_".$userFullName ."1." . $file->guessExtension();
                $file->move($utility_bills_directory, $newFilename);
                $utilityBill->setFile($newFilename);
            }
            $utilityBillsRepository->add($utilityBill, true);
            return $this->redirectToRoute('utility_bills_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('utility_bills/new.html.twig', [
            'utility_bill' => $utilityBill,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="utility_bills_show", methods={"GET"})
     */
    public function show(UtilityBills $utilityBill): Response
    {
        return $this->render('utility_bills/show.html.twig', [
            'utility_bill' => $utilityBill,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utility_bills_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, UtilityBills $utilityBill, UtilityBillsRepository $utilityBillsRepository, Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Utility Bill'
        ]);
        $form = $this->createForm(UtilityBillsType::class, $utilityBill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilityBillsRepository->add($utilityBill, true);

            return $this->redirectToRoute('utility_bills_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utility_bills/edit.html.twig', [
            'utility_bill' => $utilityBill,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="utility_bills_delete", methods={"POST"})
     */
    public function delete(Request $request, UtilityBills $utilityBill, UtilityBillsRepository $utilityBillsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilityBill->getId(), $request->request->get('_token'))) {
            $utilityBillsRepository->remove($utilityBill, true);
        }

        return $this->redirectToRoute('utility_bills_index', [], Response::HTTP_SEE_OTHER);
    }
}
