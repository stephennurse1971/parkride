<?php

namespace App\Controller;

use App\Entity\EmploymentContracts;
use App\Form\EmploymentContractsType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\EmploymentContractsRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/employment/contracts")
 */
class EmploymentContractsController extends AbstractController
{
    /**
     * @Route("/", name="employment_contracts_index", methods={"GET"})
     */
    public function index(EmploymentContractsRepository $employmentContractsRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('employment_contracts/index.html.twig', [
            'employment_contracts' => $employmentContractsRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="employment_contracts_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EmploymentContractsRepository $employmentContractsRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Employment Contract'
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
        $employmentContract = new EmploymentContracts();
        $form = $this->createForm(EmploymentContractsType::class, $employmentContract,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {
                $userFullName = $employmentContract->getEmployee()->getFullName();
                $employment_contract_directory = $this->getParameter('employment_contracts_attachments_directory');
                $file = $form->get('file')->getData();
                if ($file) {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = "Employment_Contract_".$userFullName .".". $file->guessExtension();
                    $file->move($employment_contract_directory, $newFilename);
                    $employmentContract->setFile($newFilename);
                }

            $employmentContractsRepository->add($employmentContract, true);

            return $this->redirectToRoute('employment_contracts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employment_contracts/new.html.twig', [
            'employment_contract' => $employmentContract,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="employment_contracts_show", methods={"GET"})
     */
    public function show(EmploymentContracts $employmentContract): Response
    {
        return $this->render('employment_contracts/show.html.twig', [
            'employment_contract' => $employmentContract,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employment_contracts_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EmploymentContracts $employmentContract, EmploymentContractsRepository $employmentContractsRepository, Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $form = $this->createForm(EmploymentContractsType::class, $employmentContract);
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Employment Contract'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employmentContractsRepository->add($employmentContract, true);
            return $this->redirectToRoute('employment_contracts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employment_contracts/edit.html.twig', [
            'employment_contract' => $employmentContract,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="app_employment_contracts_delete", methods={"POST"})
     */
    public function delete(Request $request, EmploymentContracts $employmentContract, EmploymentContractsRepository $employmentContractsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employmentContract->getId(), $request->request->get('_token'))) {
            $employmentContractsRepository->remove($employmentContract, true);
        }

        return $this->redirectToRoute('employment_contracts_index', [], Response::HTTP_SEE_OTHER);
    }
}
