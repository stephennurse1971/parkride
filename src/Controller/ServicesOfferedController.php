<?php

namespace App\Controller;

use App\Entity\ServicesOffered;
use App\Form\ServicesOfferedType;
use App\Repository\ServicesOfferedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/servicesoffered")
 * @Security("is_granted('ROLE_STAFF')")
 */
class ServicesOfferedController extends AbstractController
{
    /**
     * @Route("/", name="services_offered_index", methods={"GET"})
     */
    public function index(ServicesOfferedRepository $servicesOfferedRepository): Response
    {
        return $this->render('services_offered/index.html.twig', [
            'services_offereds' => $servicesOfferedRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="services_offered_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ServicesOfferedRepository $servicesOfferedRepository): Response
    {
        $servicesOffered = new ServicesOffered();
        $form = $this->createForm(ServicesOfferedType::class, $servicesOffered);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $servicesOfferedRepository->add($servicesOffered, true);

            return $this->redirectToRoute('services_offered_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('services_offered/new.html.twig', [
            'services_offered' => $servicesOffered,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="services_offered_show", methods={"GET"})
     */
    public function show(ServicesOffered $servicesOffered): Response
    {
        return $this->render('services_offered/show.html.twig', [
            'services_offered' => $servicesOffered,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="services_offered_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ServicesOffered $servicesOffered, ServicesOfferedRepository $servicesOfferedRepository): Response
    {
        $form = $this->createForm(ServicesOfferedType::class, $servicesOffered);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $servicesOfferedRepository->add($servicesOffered, true);

            return $this->redirectToRoute('services_offered_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('services_offered/edit.html.twig', [
            'services_offered' => $servicesOffered,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/fast_edit/{id}/{action}/{document}", name="services_offered_fast_edit", methods={"GET", "POST"})
     */
    public function fastEdit(Request $request, int $id, string $action, string $document, ServicesOfferedRepository $servicesOfferedRepository, EntityManagerInterface $manager): Response
    {
        $servicesOffered = $servicesOfferedRepository->find($id);

        if ($action == 'turn_on' and $document == 'passport') {
            $servicesOffered->setDocsPassport(1);
        }

        if ($action == 'turn_off' and $document == 'passport') {
            $servicesOffered->setDocsPassport(0);
        }


        if ($action == 'turn_on' and $document == 'tenancy_agreement') {
            $servicesOffered->setDocsTenancyAgreement(1);
        }

        if ($action == 'turn_off' and $document == 'tenancy_agreement') {
            $servicesOffered->setDocsTenancyAgreement(0);
        }

        if ($action == 'turn_on' and $document == 'utility_bills') {
            $servicesOffered->setDocsUtilityBill(1);
        }

        if ($action == 'turn_off' and $document == 'utility_bills') {
            $servicesOffered->setDocsUtilityBill(0);
        }

        if ($action == 'turn_on' and $document == 'employment_contract') {
            $servicesOffered->setDocsEmploymentContract(1);
        }

        if ($action == 'turn_off' and $document == 'employment_contract') {
            $servicesOffered->setDocsEmploymentContract(0);
        }

        if ($action == 'turn_on' and $document == 'financial_statements') {
            $servicesOffered->setDocsFinancialStatements(1);
        }

        if ($action == 'turn_off' and $document == 'financial_statements') {
            $servicesOffered->setDocsFinancialStatements(0);
        }

        if ($action == 'turn_on' and $document == 'p60') {
            $servicesOffered->setDocsP60(1);
        }

        if ($action == 'turn_off' and $document == 'p60') {
            $servicesOffered->setDocsP60(0);
        }

        if ($action == 'turn_on' and $document == 'school_attendance_certificate') {
            $servicesOffered->setDocsSchoolAttendanceCertificate(1);
        }

        if ($action == 'turn_off' and $document == 'school_attendance_certificate') {
            $servicesOffered->setDocsSchoolAttendanceCertificate(0);
        }

        if ($action == 'turn_on' and $document == 'birth_marriage_death_certificate') {
            $servicesOffered->setDocsBirthMarriageDeathCertificate(1);
        }

        if ($action == 'turn_off' and $document == 'birth_marriage_death_certificate') {
            $servicesOffered->setDocsBirthMarriageDeathCertificate(0);
        }

        if ($action == 'turn_on' and $document == 'criminal_record_check') {
            $servicesOffered->setDocsCriminalRecordCheck(1);
        }

        if ($action == 'turn_off' and $document == 'criminal_record_check') {
            $servicesOffered->setDocsCriminalRecordCheck(0);
        }

        if ($action == 'turn_on' and $document == 'health_insurance') {
            $servicesOffered->setDocsHealthInsurance(1);
        }

        if ($action == 'turn_off' and $document == 'health_insurance') {
            $servicesOffered->setDocsHealthInsurance(0);
        }

        if ($action == 'turn_on' and $document == 'medical') {
            $servicesOffered->setDocsMedical(1);
        }

        if ($action == 'turn_off' and $document == 'medical') {
            $servicesOffered->setDocsMedical(0);
        }

        if ($action == 'turn_on' and $document == 'driving_license') {
            $servicesOffered->setDocsDrivingLicense(1);
        }

        if ($action == 'turn_off' and $document == 'driving_license') {
            $servicesOffered->setDocsDrivingLicense(0);
        }

        $manager->flush();
        return $this->redirectToRoute('services_offered_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/delete/{id}", name="services_offered_delete", methods={"POST"})
     */
    public function delete(Request $request, ServicesOffered $servicesOffered, ServicesOfferedRepository $servicesOfferedRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $servicesOffered->getId(), $request->request->get('_token'))) {
            $servicesOfferedRepository->remove($servicesOffered, true);
        }

        return $this->redirectToRoute('services_offered_index', [], Response::HTTP_SEE_OTHER);
    }
}
