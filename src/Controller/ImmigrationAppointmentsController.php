<?php

namespace App\Controller;

use App\Entity\ImmigrationAppointments;
use App\Form\ImmigrationAppointmentsType;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/immigration/appointments")
 */
class ImmigrationAppointmentsController extends AbstractController
{
    /**
     * @Route("/", name="immigration_appointments_index", methods={"GET"})
     */
    public function index(ImmigrationAppointmentsRepository $immigrationAppointmentsRepository): Response
    {
        $today = new \DateTime('now');
//        $todayhour = new \DateTime('now')|date('H');
        $todayhour = '16';
        return $this->render('immigration_appointments/index.html.twig', [
            'immigration_appointments' => $immigrationAppointmentsRepository->findAll(),
            'today' => $today,
            'todayHour' => $todayhour,
            'officeOrPIA' =>'Office'
        ]);
    }

    /**
     * @Route("/new", name="immigration_appointments_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, UserRepository $userRepository): Response
    {
        $immigrationAppointment = new ImmigrationAppointments();
        $form = $this->createForm(ImmigrationAppointmentsType::class, $immigrationAppointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $immigrationAppointmentsRepository->add($immigrationAppointment, true);
            return $this->redirectToRoute('immigration_appointments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('immigration_appointments/new.html.twig', [
            'immigration_appointment' => $immigrationAppointment,
            'form' => $form,

        ]);
    }

    /**
     * @Route("/new_from_client_availability/{date}/{time}", name="immigration_appointments_new_from_client_availability", methods={"GET", "POST"})
     */
    public function newFromClientAvailabilty(Request $request, string $date, int $time, EntityManagerInterface $manager): Response
    {
        $immigrationAppointment = new ImmigrationAppointments();
        $immigrationAppointment->setTime($time)
            ->setDate(new \DateTime($date));
        $manager->persist($immigrationAppointment);
        $manager->flush();
        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @Route("/add_client_to_immigration_slot/{id}/{client}", name="immigration_appointments_add_client", methods={"GET", "POST"})
     */
    public function addClientFromClientAvailabilty(Request $request, string $client, int $id, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        $client = $userRepository->find($client);
        $immigrationAppointment = $immigrationAppointmentsRepository->find($id);
        $immigrationAppointment->setClient($client);
        $manager->flush();
        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @Route("/{id}", name="immigration_appointments_show", methods={"GET"})
     */
    public function show(ImmigrationAppointments $immigrationAppointment): Response
    {
        return $this->render('immigration_appointments/show.html.twig', [
            'immigration_appointment' => $immigrationAppointment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="immigration_appointments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ImmigrationAppointments $immigrationAppointment, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, UserRepository $userRepository): Response
    {
        $form = $this->createForm(ImmigrationAppointmentsType::class, $immigrationAppointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $immigrationAppointmentsRepository->add($immigrationAppointment, true);

            return $this->redirectToRoute('client_availability_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('immigration_appointments/edit.html.twig', [
            'immigration_appointment' => $immigrationAppointment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/confirm_or_reject_immigration_appointment/{id}/{status}", name="immigration_appointments_confirm_or_reject_immigration_appointment", methods={"GET", "POST"})
     */
    public function confirmRejectImmigrationAppointment(Request $request, id $id, string $status, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, EntityManagerInterface $manager): Response
    {
        $immigrationAppointment = $immigrationAppointmentsRepository->find($id);
        if ($status=='Accept'){
            $immigrationAppointment->setCalendarReceipt('Confirmed');
        }
        if ($status=='Reject'){
            $immigrationAppointment->setCalendarReceipt('Reject');
        }
        $manager->flush();
        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @Route("/{id}/remove_client", name="immigration_appointments_remove_client", methods={"GET", "POST"})
     */
    public function remove_client(Request $request, int $id, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, EntityManagerInterface $manager): Response
    {
        $immigrationAppointment = $immigrationAppointmentsRepository->find($id);
        $immigrationAppointment->setClient(null);
        $manager->flush();
        return $this->redirect($request->headers->get('Referer'));
    }


    /**
     * @Route("/{id}", name="immigration_appointments_delete", methods={"POST"})
     */
    public function delete(Request $request, ImmigrationAppointments $immigrationAppointment, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $immigrationAppointment->getId(), $request->request->get('_token'))) {
            $immigrationAppointmentsRepository->remove($immigrationAppointment, true);
        }

        return $this->redirectToRoute('immigration_appointments_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/delete/all", name="immigration_appointments_delete_all")
     */
    public function deleteAll(Request $request, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, EntityManagerInterface $manager): Response
    {
        $referrer = $request->headers->get('Referer');
        $immigration_appointments = $immigrationAppointmentsRepository->findAll();
        foreach ($immigration_appointments as $immigration_appointment) {
            $manager->remove($immigration_appointment);
        }
        $manager->flush();
        return $this->redirect($referrer);
    }
}
