<?php

namespace App\Controller;

use App\Entity\FinancialStatements;
use App\Form\FinancialStatementsType;
use App\Repository\CurrenciesRepository;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\FinancialStatementsRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/financial/statements")
 */
class FinancialStatementsController extends AbstractController
{
    /**
     * @Route("/", name="financial_statements_index", methods={"GET"})
     */
    public function index(FinancialStatementsRepository $financialStatementsRepository, CurrenciesRepository $currenciesRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('financial_statements/index.html.twig', [
            'financial_statements' => $financialStatementsRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
            'currencies' => $currenciesRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="financial_statements_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FinancialStatementsRepository $financialStatementsRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Financial Statement'
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
        $financialStatement = new FinancialStatements();
        $form = $this->createForm(FinancialStatementsType::class, $financialStatement,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $financialStatement->getAccountHolder()->getFullName();
            $financials_directory = $this->getParameter('financials_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Financial_Statement_".$userFullName ."1." . $file->guessExtension();
                $file->move($financials_directory, $newFilename);
                $financialStatement->setFile($newFilename);
            }
            $financialStatementsRepository->add($financialStatement, true);
            return $this->redirectToRoute('financial_statements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('financial_statements/new.html.twig', [
            'financial_statement' => $financialStatement,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="financial_statements_show", methods={"GET"})
     */
    public function show(FinancialStatements $financialStatement): Response
    {
        return $this->render('financial_statements/show.html.twig', [
            'financial_statement' => $financialStatement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="financial_statements_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FinancialStatements $financialStatement, FinancialStatementsRepository $financialStatementsRepository  , Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {

        $userFullName = $financialStatement->getAccountHolder()->getFullName();
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Financial Statement'
        ]);
        $form = $this->createForm(FinancialStatementsType::class, $financialStatement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $financials_directory = $this->getParameter('financials_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Financial_Statement_".$userFullName ."1." . $file->guessExtension();
                $file->move($financials_directory, $newFilename);
                $financialStatement->setFile($newFilename);
            }

            $financialStatementsRepository->add($financialStatement, true);
            return $this->redirectToRoute('financial_statements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('financial_statements/edit.html.twig', [
            'financial_statement' => $financialStatement,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="financial_statements_delete", methods={"POST"})
     */
    public function delete(Request $request, FinancialStatements $financialStatement, FinancialStatementsRepository $financialStatementsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$financialStatement->getId(), $request->request->get('_token'))) {
            $financialStatementsRepository->remove($financialStatement, true);
        }

        return $this->redirectToRoute('financial_statements_index', [], Response::HTTP_SEE_OTHER);
    }
}
