<?php

namespace App\Controller;

use App\Entity\Passports;
use App\Entity\TaxInputs;
use App\Form\PassportsType;
use App\Repository\DocumentationErrorsRepository;
use App\Repository\DocumentGuidelinesRepository;
use App\Repository\PassportsRepository;
use App\Repository\UserRepository;
use App\Services\DocumentAuditTracker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/passports")
 */
class PassportsController extends AbstractController
{
    /**
     * @Route("/", name="passports_index", methods={"GET"})
     */
    public function index(PassportsRepository $passportsRepository, DocumentationErrorsRepository $documentationErrorsRepository): Response
    {
        return $this->render('passports/index.html.twig', [
            'passports' => $passportsRepository->findAll(),
            'documentErrors' => $documentationErrorsRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="passports_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PassportsRepository $passportsRepository, UserRepository $userRepository, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Passport'
        ]);
        $clients = $userRepository->findAll();
        $reviewed_By = [];
        foreach ($userRepository->findAll() as $client) {
            if (in_array('ROLE_STAFF', $client->getRoles())) {
                $reviewed_By[] = $client;
            }
        }
        if ($request->query->get('client')) {
            $client_name = $request->query->get('client');
            $client_name = explode(' ', $client_name);
            $first_name = $client_name[0];
            $last_name = $client_name[1];
            $clients = $userRepository->findBy(['firstName' => $first_name, 'lastName' => $last_name]);
        }
        $passport = new Passports();
        $form = $this->createForm(PassportsType::class, $passport, ['clients' => $clients, 'reviewed_By' => $reviewed_By]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $passport->getPassportHolder()->getFullName();
            $passports_directory = $this->getParameter('passports_attachments_directory');
            $passportScan1 = $form->get('passportScan1')->getData();
            if ($passportScan1) {
                $originalFilename = pathinfo($passportScan1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Passport_" . $userFullName . "1." . $passportScan1->guessExtension();
                $passportScan1->move($passports_directory, $newFilename);
                $passport->setPassportScan1($newFilename);
            }
            $passportScan2 = $form->get('passportScan2')->getData();
            if ($passportScan2) {
                $userFullName = $passport->getPassportHolder()->getFullName();
                $originalFilename = pathinfo($passportScan2->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Passport_" . $userFullName . '2.' . $passportScan2->guessExtension();
                $passportScan2->move($passports_directory, $newFilename);
                $passport->setPassportScan2($newFilename);
            }
            $passportsRepository->add($passport, true);
            return $this->redirectToRoute('passports_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('passports/new.html.twig', [
            'passport' => $passport,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }

    /**
     * @Route("/{id}", name="passports_show", methods={"GET"})
     */
    public function show(Passports $passport): Response
    {
        return $this->render('passports/show.html.twig', [
            'passport' => $passport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="passports_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Passports $passport, PassportsRepository $passportsRepository, Security $security, DocumentAuditTracker $auditTracker, DocumentationErrorsRepository $documentationErrorsRepository, DocumentGuidelinesRepository $documentGuidelinesRepository): Response
    {
        $old_passport = clone $passport;
        $userFullName = $passport->getPassportHolder()->getFullName();
        $guidelines = $documentGuidelinesRepository->findOneBy([
            'document' => 'Passport'
        ]);

        $form = $this->createForm(PassportsType::class, $passport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $referer = $request->request->get('referer');
            $passports_directory = $this->getParameter('passports_attachments_directory');
            $passportScan1 = $form->get('passportScan1')->getData();
            if ($passportScan1) {
                $originalFilename = pathinfo($passportScan1->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Passport_" . $userFullName . "1." . $passportScan1->guessExtension();
                $passportScan1->move($passports_directory, $newFilename);
                $passport->setPassportScan1($newFilename);
            }
            $passportScan2 = $form->get('passportScan2')->getData();
            if ($passportScan2) {
                $originalFilename = pathinfo($passportScan2->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Passport_" . $userFullName . '2.' . $passportScan2->guessExtension();
                $passportScan2->move($passports_directory, $newFilename);
                $passport->setPassportScan2($newFilename);
            }

            $passportsRepository->add($passport, true);
            $changes_count = $auditTracker->update($old_passport, $passport, 'passport', $security->getUser(), $passport->getPassportHolder());
            if ($changes_count > 0 && $passport->getPassportHolder() == $security->getUser()) {
                $passport->setReviewed('Pending')
                    ->setReviewedBy(null)
                    ->setReviewedDate(null);
                $passportsRepository->add($passport, true);
            }

            return $this->redirect($referer);
        }

        return $this->renderForm('passports/edit.html.twig', [
            'passport' => $passport,
            'form' => $form,
            'guidelines' => $guidelines,
        ]);
    }


    /**
     * @Route("/{id}", name="passports_delete", methods={"POST"})
     */
    public
    function delete(Request $request, Passports $passport, PassportsRepository $passportsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $passport->getId(), $request->request->get('_token'))) {
            $passportsRepository->remove($passport, true);
        }

        return $this->redirectToRoute('passports_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/delete/passport/{id}/{filetype}", name="passport_delete_uploaded_file", methods={"GET"})
     */
    public function deleteUploadedFile(Request $request, int $filetype, Passports $passport, PassportsRepository $passportsRepository): Response
    {
        $referer = $request->headers->get('Referer');
        if ($filetype == 1) {
            $passport->setPassportScan1(null);
            $passportsRepository->add($passport, true);
        }
        if ($filetype == 2) {
            $passport->setPassportScan2(null);
            $passportsRepository->add($passport, true);
        }
        return $this->redirect($referer);
    }

}
