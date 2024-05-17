<?php

namespace App\Controller;

use App\Entity\SchoolAttendanceCertificates;
use App\Form\SchoolAttendanceCertificatesType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\SchoolAttendanceCertificatesRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/school/attendance/certificates")
 */
class SchoolAttendanceCertificatesController extends AbstractController
{
    /**
     * @Route("/", name="school_attendance_certificates_index", methods={"GET"})
     */
    public function index(SchoolAttendanceCertificatesRepository $schoolAttendanceCertificatesRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('school_attendance_certificates/index.html.twig', [
            'school_attendance_certificates' => $schoolAttendanceCertificatesRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="school_attendance_certificates_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SchoolAttendanceCertificatesRepository $schoolAttendanceCertificatesRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'School Attendance Certificate'
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
        $schoolAttendanceCertificate = new SchoolAttendanceCertificates();
        $form = $this->createForm(SchoolAttendanceCertificatesType::class, $schoolAttendanceCertificate,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $schoolAttendanceCertificate->getStudent()->getFullName();
            $financials_directory = $this->getParameter('school_attendance_certificate_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "School_Attendance_Certificate_".$userFullName ."1." . $file->guessExtension();
                $file->move($financials_directory, $newFilename);
                $schoolAttendanceCertificate->setFile($newFilename);
            }

            $schoolAttendanceCertificatesRepository->add($schoolAttendanceCertificate, true);

            return $this->redirectToRoute('school_attendance_certificates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('school_attendance_certificates/new.html.twig', [
            'school_attendance_certificate' => $schoolAttendanceCertificate,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="school_attendance_certificates_show", methods={"GET"})
     */
    public function show(SchoolAttendanceCertificates $schoolAttendanceCertificate): Response
    {
        return $this->render('school_attendance_certificates/show.html.twig', [
            'school_attendance_certificate' => $schoolAttendanceCertificate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="school_attendance_certificates_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SchoolAttendanceCertificates $schoolAttendanceCertificate, SchoolAttendanceCertificatesRepository $schoolAttendanceCertificatesRepository,Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'School Attendance Certificate'
        ]);
        $form = $this->createForm(SchoolAttendanceCertificatesType::class, $schoolAttendanceCertificate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $schoolAttendanceCertificatesRepository->add($schoolAttendanceCertificate, true);

            return $this->redirectToRoute('school_attendance_certificates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('school_attendance_certificates/edit.html.twig', [
            'school_attendance_certificate' => $schoolAttendanceCertificate,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="school_attendance_certificates_delete", methods={"POST"})
     */
    public function delete(Request $request, SchoolAttendanceCertificates $schoolAttendanceCertificate, SchoolAttendanceCertificatesRepository $schoolAttendanceCertificatesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$schoolAttendanceCertificate->getId(), $request->request->get('_token'))) {
            $schoolAttendanceCertificatesRepository->remove($schoolAttendanceCertificate, true);
        }

        return $this->redirectToRoute('school_attendance_certificates_index', [], Response::HTTP_SEE_OTHER);
    }
}
