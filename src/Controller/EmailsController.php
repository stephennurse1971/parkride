<?php

namespace App\Controller;

use App\Entity\Emails;
use App\Form\EmailsType;
use App\Form\EmailTemplatesType;
use App\Repository\CmsRepository;
use App\Repository\EmailsRepository;
use App\Repository\EmailTemplatesRepository;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\OfficeAppointmentsRepository;
use App\Repository\TransactionRepository;
use App\Services\StringReplace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/emails")
 */
class EmailsController extends AbstractController
{
    /**
     * @Route("/", name="emails_index", methods={"GET"})
     */
    public function index(EmailsRepository $emailsRepository): Response
    {
        return $this->render('emails/index.html.twig', [
            'emails' => $emailsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="emails_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EmailsRepository $emailsRepository): Response
    {
        $email = new Emails();
        $form = $this->createForm(EmailsType::class, $email);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailsRepository->add($email, true);

            return $this->redirectToRoute('emails_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emails/new.html.twig', [
            'email' => $email,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="emails_show", methods={"GET"})
     */
    public function show(Emails $email): Response
    {
        return $this->render('emails/show.html.twig', [
            'email' => $email,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="emails_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Emails $email, EmailsRepository $emailsRepository): Response
    {
        $form = $this->createForm(EmailsType::class, $email);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailsRepository->add($email, true);

            return $this->redirectToRoute('emails_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emails/edit.html.twig', [
            'email' => $email,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="emails_delete", methods={"POST"})
     */
    public function delete(Request $request, Emails $email, EmailsRepository $emailsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $email->getId(), $request->request->get('_token'))) {
            $emailsRepository->remove($email, true);
        }

        return $this->redirectToRoute('emails_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/send/email/{templateId}/{transactionId}", name="send_email")
     */
    public function sendMail(StringReplace $stringReplace,Request $request, int $templateId, int $transactionId, MailerInterface $mailer, EmailTemplatesRepository $emailTemplatesRepository, TransactionRepository $transactionRepository, EntityManagerInterface $manager)
    {
        $now = new \DateTime('now');
        $referrer = $request->headers->get('Referer');
        $template = $emailTemplatesRepository->find($templateId);
        $transaction = $transactionRepository->find($transactionId);
        $body = $stringReplace->replace($transaction,$template);
//        $newEmail = new Emails();
//        $newEmail->setDateTime($now)
//            ->setRecipientName($transaction->getClient()->getFullName())
//            ->setSubject($template->getSubject())
//           // ->setBody($template->getBody())
//               ->setBody($body)
//            ->setClient($transaction->getClient())
//            ->setService($template->getService())
//            ->setStage($template->getStage());
//        $form = $this->createForm(EmailsType::class, $newEmail);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
////            $newEmail->setDateTime($now)
////                ->setRecipientName($transaction->getClient()->getFullName())
////                ->setSubject($template->getSubject())
////                ->setBody($template->getBody())
////                ->setClient($transaction->getClient())
////                ->setService($template->getService())
////                ->setStage($template->getStage());
//            $manager->persist($newEmail);
//            $manager->flush();
//            return $this->redirectToRoute('transaction_index');
//        }
//
//        return $this->renderForm('emails/new.html.twig', [
//            'emails' => $newEmail,
//            'form' => $form,
//        ]);

        $email = (new Email())
//            ->from($template->getSentFrom())
//            ->to($template->getRecipientTo())
            ->from('nurse_stephen@hotmail.com')
            ->to('sjwn71@gmail.com')

            ->subject($template->getSubject())
            ->html($body);
        $mailer->send($email);


        return $this->redirect($referrer);
    }

    /**
     * @Route("/email_template/'Office_Meeting'/{officeAppointmentId}", name="email_template_office_meeting", methods={"GET"})
     */
    public function emailTemplateOfficeMeeting(id $officeAppointmentId, Emails $email, EmailTemplatesRepository $emailTemplatesRepository, OfficeAppointmentsRepository $officeAppointmentsRepository, CmsRepository $cmsRepository): Response
    {
        return $this->render('emails/officeMeetingConfirmation.html.twig', [
            'template' => $emailTemplatesRepository->findOneBy([
                'name' => 'Office Appointment'
            ]),
            'appointment' => $officeAppointmentsRepository->findOneBy($id),
            'cms' => $cmsRepository->find('1')
        ]);
    }


    /**
     * @Route("/email_template/'PIA_Meeting'/{officeAppointmentId}", name="email_template_pia_meeting", methods={"GET"})
     */
    public function emailTemplateImmigrationOfficeMeeting(id $officeAppointmentId, Emails $email, EmailTemplatesRepository $emailTemplatesRepository, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, CmsRepository $cmsRepository): Response
    {
        return $this->render('emails/immigtrationOfficeMeetingConfirmation.html.twig', [
            'template' => $emailTemplatesRepository->findOneBy([
                'name' => 'Immigration Office Appointment'
            ]),
            'appointment' => $immigrationAppointmentsRepository->findOneBy($id),
            'cms' => $cmsRepository->find('1')
        ]);
    }

}
