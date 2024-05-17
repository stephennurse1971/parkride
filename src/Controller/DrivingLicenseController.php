<?php

namespace App\Controller;

use App\Entity\DrivingLicense;
use App\Form\DrivingLicenseType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\DrivingLicenseRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/driving/license")
 */
class DrivingLicenseController extends AbstractController
{
    /**
     * @Route("/", name="driving_license_index", methods={"GET"})
     */
    public function index(DrivingLicenseRepository $drivingLicenseRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('driving_license/index.html.twig', [
            'driving_licenses' => $drivingLicenseRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="driving_license_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DrivingLicenseRepository $drivingLicenseRepository,UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Driving License'
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
        $drivingLicense = new DrivingLicense();
        $form = $this->createForm(DrivingLicenseType::class, $drivingLicense,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $drivingLicense->getDrivingLicenseHolder()->getFullName();
            $driving_license_directory = $this->getParameter('drivinglicenses_attachments_directory');
            $licenseScan1 = $form->get('licenseScan1')->getData();
            if ($licenseScan1) {
                $originalFilename = pathinfo($licenseScan1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Driving_License_" . $userFullName . "1." . $licenseScan1->guessExtension();
                $licenseScan1->move($driving_license_directory, $newFilename);
                $drivingLicense->setLicenseScan1($newFilename);
            }
            $licenseScan2 = $form->get('licenseScan2')->getData();
            if ($licenseScan2) {
                $originalFilename = pathinfo($licenseScan1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Driving_License_" . $userFullName . "2." . $licenseScan2->guessExtension();
                $licenseScan2->move($driving_license_directory, $newFilename);
                $drivingLicense->setLicenseScan2($newFilename);
            }
            $drivingLicenseRepository->add($drivingLicense, true);
            return $this->redirectToRoute('driving_license_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('driving_license/new.html.twig', [
            'driving_license' => $drivingLicense,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="app_driving_license_show", methods={"GET"})
     */
    public function show(DrivingLicense $drivingLicense): Response
    {
        return $this->render('driving_license/show.html.twig', [
            'driving_license' => $drivingLicense,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="driving_license_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, DrivingLicense $drivingLicense, DrivingLicenseRepository $drivingLicenseRepository,Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $form = $this->createForm(DrivingLicenseType::class, $drivingLicense);
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Driving License'
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $drivingLicense->getDrivingLicenseHolder()->getFullName();
            $driving_license_directory = $this->getParameter('drivinglicenses_attachments_directory');
            $licenseScan1 = $form->get('licenseScan1')->getData();
            if ($licenseScan1) {
                $originalFilename = pathinfo($licenseScan1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Driving_License_" . $userFullName . "1." . $licenseScan1->guessExtension();
                $licenseScan1->move($driving_license_directory, $newFilename);
                $drivingLicense->setLicenseScan1($newFilename);
            }
            $licenseScan2 = $form->get('licenseScan2')->getData();
            if ($licenseScan2) {
                $originalFilename = pathinfo($licenseScan1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Driving_License_" . $userFullName . "2." . $licenseScan2->guessExtension();
                $licenseScan2->move($driving_license_directory, $newFilename);
                $drivingLicense->setLicenseScan2($newFilename);
            }

        $drivingLicenseRepository->add($drivingLicense, true);
        return $this->redirectToRoute('driving_license_index', [], Response::HTTP_SEE_OTHER);
    }
        return $this->renderForm('driving_license/edit.html.twig', [
            'driving_license' => $drivingLicense,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="driving_license_delete", methods={"POST"})
     */
    public
    function delete(Request $request, DrivingLicense $drivingLicense, DrivingLicenseRepository $drivingLicenseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $drivingLicense->getId(), $request->request->get('_token'))) {
            $drivingLicenseRepository->remove($drivingLicense, true);
        }

        return $this->redirectToRoute('driving_license_index', [], Response::HTTP_SEE_OTHER);
    }
}
