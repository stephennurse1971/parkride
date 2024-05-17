<?php

namespace App\Controller;

use App\Entity\HealthInsurance;
use App\Form\HealthInsuranceType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\HealthInsuranceRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/health/insurance")
 */
class HealthInsuranceController extends AbstractController
{
    /**
     * @Route("/", name="health_insurance_index", methods={"GET"})
     */
    public function index(HealthInsuranceRepository $healthInsuranceRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('health_insurance/index.html.twig', [
            'health_insurances' => $healthInsuranceRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="health_insurance_new", methods={"GET", "POST"})
     */
    public function new(Request $request, HealthInsuranceRepository $healthInsuranceRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Health Insurance'
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
        $healthInsurance = new HealthInsurance();
        $form = $this->createForm(HealthInsuranceType::class, $healthInsurance,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $healthInsurance->getApplicant()->getFullName();
            $health_insurance_directory = $this->getParameter('health_insurance_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Health_Insurance_".$userFullName ."1." . $file->guessExtension();
                $file->move($health_insurance_directory, $newFilename);
                $healthInsurance->setFile($newFilename);
            }

            $healthInsuranceRepository->add($healthInsurance, true);

            return $this->redirectToRoute('health_insurance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('health_insurance/new.html.twig', [
            'health_insurance' => $healthInsurance,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="health_insurance_show", methods={"GET"})
     */
    public function show(HealthInsurance $healthInsurance): Response
    {
        return $this->render('health_insurance/show.html.twig', [
            'health_insurance' => $healthInsurance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="health_insurance_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, HealthInsurance $healthInsurance, HealthInsuranceRepository $healthInsuranceRepository, Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Health Insurance'
        ]);
        $form = $this->createForm(HealthInsuranceType::class, $healthInsurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $healthInsuranceRepository->add($healthInsurance, true);

            return $this->redirectToRoute('health_insurance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('health_insurance/edit.html.twig', [
            'health_insurance' => $healthInsurance,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="health_insurance_delete", methods={"POST"})
     */
    public function delete(Request $request, HealthInsurance $healthInsurance, HealthInsuranceRepository $healthInsuranceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$healthInsurance->getId(), $request->request->get('_token'))) {
            $healthInsuranceRepository->remove($healthInsurance, true);
        }

        return $this->redirectToRoute('health_insurance_index', [], Response::HTTP_SEE_OTHER);
    }
}
