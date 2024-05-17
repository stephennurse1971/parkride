<?php

namespace App\Controller;

use App\Entity\BirthDeathMarriageCertificates;
use App\Form\BirthDeathMarriageCertificatesType;
use App\Repository\BirthDeathMarriageCertificatesRepository;
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
 * @Route("/birth/death/marriage/certificates")
 */
class BirthDeathMarriageCertificatesController extends AbstractController
{
    /**
     * @Route("/", name="birth_death_marriage_certificates_index", methods={"GET"})
     */
    public function index(BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {

        return $this->render('birth_death_marriage_certificates/index.html.twig', [
            'birth_death_marriage_certificates' => $birthDeathMarriageCertificatesRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="birth_death_marriage_certificates_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository, UserRepository $userRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Birth Marriage Death certificate'
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
        $birthDeathMarriageCertificate = new BirthDeathMarriageCertificates();
        $form = $this->createForm(BirthDeathMarriageCertificatesType::class, $birthDeathMarriageCertificate,['clients'=>$clients,'reviewed_By'=>$reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $birthDeathMarriageCertificate->getApplicant()->getFullName();
            $birth_death_marriage_certificate_directory = $this->getParameter('birth_marriage_death_certificates_attachments_directory');
            $certificate = $form->get('certificateFile')->getData();
            if ($certificate) {
                $originalFilename = pathinfo($certificate->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "BirthDeathMarriage_".$userFullName ."1." . $certificate->guessExtension();
                $certificate->move($birth_death_marriage_certificate_directory, $newFilename);
                $birthDeathMarriageCertificate->setCertificateFile($newFilename);
            }

            $birthDeathMarriageCertificatesRepository->add($birthDeathMarriageCertificate, true);
            return $this->redirectToRoute('birth_death_marriage_certificates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('birth_death_marriage_certificates/new.html.twig', [
            'birth_death_marriage_certificate' => $birthDeathMarriageCertificate,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="app_birth_death_marriage_certificates_show", methods={"GET"})
     */
    public function show(BirthDeathMarriageCertificates $birthDeathMarriageCertificate): Response
    {
        return $this->render('birth_death_marriage_certificates/show.html.twig', [
            'birth_death_marriage_certificate' => $birthDeathMarriageCertificate,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="birth_death_marriage_certificates_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BirthDeathMarriageCertificates $birthDeathMarriageCertificate, BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository,Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $form = $this->createForm(BirthDeathMarriageCertificatesType::class, $birthDeathMarriageCertificate);
        $form->handleRequest($request);
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Birth Marriage Death Certificate'
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $birthDeathMarriageCertificate->getApplicant()->getFullName();
            $birth_death_marriage_certificate_directory = $this->getParameter('birth_marriage_death_certificates_attachments_directory');
            $certificate = $form->get('certificateFile')->getData();
            if ($certificate) {
                $originalFilename = pathinfo($certificate->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "BirthDeathMarriage_".$userFullName ."1." . $certificate->guessExtension();
                $certificate->move($birth_death_marriage_certificate_directory, $newFilename);
                $birthDeathMarriageCertificate->setCertificateFile($newFilename);
            }

            $birthDeathMarriageCertificatesRepository->add($birthDeathMarriageCertificate, true);
            return $this->redirectToRoute('birth_death_marriage_certificates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('birth_death_marriage_certificates/edit.html.twig', [
            'birth_death_marriage_certificate' => $birthDeathMarriageCertificate,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="birth_death_marriage_certificates_delete", methods={"POST"})
     */
    public function delete(Request $request, BirthDeathMarriageCertificates $birthDeathMarriageCertificate, BirthDeathMarriageCertificatesRepository $birthDeathMarriageCertificatesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$birthDeathMarriageCertificate->getId(), $request->request->get('_token'))) {
            $birthDeathMarriageCertificatesRepository->remove($birthDeathMarriageCertificate, true);
        }

        return $this->redirectToRoute('birth_death_marriage_certificates_index', [], Response::HTTP_SEE_OTHER);
    }
}
