<?php

namespace App\Controller;

use App\Entity\Emails;
use App\Entity\OfficeAppointments;
use App\Form\OfficeAppointmentsType;
use App\Repository\CmsRepository;
use App\Repository\EmailTemplatesRepository;
use App\Repository\EmployeeCalendarSetUpRepository;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\OfficeAppointmentsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;
use Jsvrcek\ICS\Model\Description\Location;
use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Model\Relationship\Organizer;
use Jsvrcek\ICS\Utility\Formatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/office_appointments")
 */
class OfficeAppointmentsController extends AbstractController
{
    /**
     * @Route("/", name="office_appointments_index", methods={"GET"})
     */
    public function index(request $request, OfficeAppointmentsRepository $officeAppointmentsRepository, EmailTemplatesRepository $emailTemplatesRepository, UserRepository $userRepository): Response
    {
        $template_id = $emailTemplatesRepository->findOneBy([
            'name' => 'Office Appointment'
        ]);
        $employees = [];
        foreach ($userRepository->findAll() as $user) {
            if (in_array('ROLE_STAFF', $user->getRoles())) {
                $employees[] = $user;
            }
        }
        $maxFutureBookings = '1';
        $officeAppointments = $officeAppointmentsRepository->findAll();
        if ($request->query->get('nextWeek')) {
            $current_previous_week_date = new \DateTime($request->query->get('previousWeek'));
            $previousWeek = $current_previous_week_date->modify("+7 days");
        }

        $week = 'week1';
        if ($request->query->get('week')) {
            $week = $request->query->get('week');
        }
        $message = '';
        if ($request->query->get('message')) {
            $message = $request->query->get('message');
        }
        $hours = [];
        for ($i = 9; $i <= 15; $i++) {
            $hours[$i]['hour'] = $i;
            $hours[$i]['sort'] = $i;
        }

        $minDate = $request->query->get('minDate');
        $maxDate = $request->query->get('maxDate');
        $today = new \DateTime('now');
        $todayHour = $today->format('H') + 2;
        $weekday = $today->format('N') - 1;
        $lastMonday = new \DateTime($today->format('Y-m-d'));
        $lastMonday->modify('-' . $weekday . ' days');
        $nextSunday = new \DateTime($lastMonday->format('Y-m-d'));
        $nextSunday->modify('+6 days');
        $daysRemainingThisWeek = 7 - $weekday;

        if ($minDate && $maxDate) {
            if ($minDate == $today->format('Y-m-d')) {
                $dates = [];
                for ($i = 0; $i < $daysRemainingThisWeek; $i++) {
                    $next_date = new \DateTime($today->format('Y-m-d'));
                    $next_date->modify($i . 'days');
                    $dates[$i] = $next_date;
                }
            } else {
                $dates = [];
                $dates[0] = new \DateTime($minDate);
                for ($i = 1; $i <= 4; $i++) {
                    $next_date = new \DateTime($minDate);
                    $next_date->modify($i . 'days');
                    $dates[$i] = $next_date;
                }
            }
        } else {
            $dates = [];
            for ($i = 0; $i < $daysRemainingThisWeek; $i++) {
                $next_date = new \DateTime($today->format('Y-m-d'));
                $next_date->modify($i . 'days');
                $dates[$i] = $next_date;
            }
        }
        $monday2 = new \DateTime($lastMonday->format('Y-m-d'));
        $monday3 = new \DateTime($lastMonday->format('Y-m-d'));
        $sunday2 = new \DateTime($nextSunday->format('Y-m-d'));
        $sunday3 = new \DateTime($nextSunday->format('Y-m-d'));
        $monday2->modify('+7 days');
        $monday3->modify('+14 days');
        $sunday2->modify('+7 days');
        $sunday3->modify('+14 days');

        return $this->render('office_appointments/index.html.twig', [
            'office_appointments' => $officeAppointments,
            'template_id' => $template_id,
            'dates' => $dates,
            'hours' => $hours,
            'minDate' => $request->query->get('minDate'),
            'maxDate' => $request->query->get('maxDate'),
            'lastMonday' => $lastMonday,
            'nextSunday' => $nextSunday,
            'monday2' => $monday2,
            'monday3' => $monday3,
            'sunday2' => $sunday2,
            'sunday3' => $sunday3,
            'week' => $week,
            'maxFutureBookings' => $maxFutureBookings,
            'today' => $today,
            'todayHour' => $todayHour,
            'employees' => $employees,
            'officeOrPIA' => 'Office'
        ]);

    }


    /**
     * @Route("/client_index", name="office_appointments_index_client", methods={"GET"})
     */
    public function indexClient(request $request, OfficeAppointmentsRepository $officeAppointmentsRepository): Response
    {
        $maxFutureBookings = '1';
        $officeAppointments = $officeAppointmentsRepository->findAll();
        $hours = [];
        for ($i = 9; $i <= 15; $i++) {
            $hours[$i]['hour'] = $i;
            $hours[$i]['sort'] = $i;
        }
        $today = new \DateTime('now');
        $todayHour = $today->format('H') + 2;
        $weekday = $today->format('N') - 1;
        $daysRemainingThisWeek = 7 - $weekday;
        $dates = [];
        for ($i = 0; $i < (21 + $daysRemainingThisWeek); $i++) {
            $next_date = new \DateTime($today->format('Y-m-d'));
            $next_date->modify($i . 'days');
            $dates[$i] = $next_date;
        }

        return $this->render('office_appointments/indexClient.html.twig', [
            'office_appointments' => $officeAppointments,
            'dates' => $dates,
            'hours' => $hours,
            'maxFutureBookings' => $maxFutureBookings,
            'today' => $today,
            'todayHour' => $todayHour
        ]);

        return $this->render('office_appointments/indexClient.html.twig', [
            'office_appointments' => $officeAppointmentsRepository->findAll(),
        ]);
    }


    /**
     * @Route("/office_appointments_by_client/{client}", name="office_appointments_by_client", methods={"GET"})
     */
    public function indexByClient(int $client, OfficeAppointmentsRepository $officeAppointmentsRepository, UserRepository $userRepository): Response
    {
        $employees = [];
        foreach ($userRepository->findAll() as $user) {
            if (in_array('ROLE_STAFF', $user->getRoles())) {
                $employees[] = $user;
            }
        }
        $officeAppointments = $officeAppointmentsRepository->findBy([
            'client' => $client
        ]);

        return $this->render('office_appointments/indexByClient.html.twig', [
            'office_appointments' => $officeAppointments,
            'employees' => $employees
        ]);


    }


    /**
     * @Route("/new", name="office_appointments_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OfficeAppointmentsRepository $officeAppointmentsRepository): Response
    {
        $officeAppointment = new OfficeAppointments();
        $form = $this->createForm(OfficeAppointmentsType::class, $officeAppointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $officeAppointmentsRepository->add($officeAppointment, true);

            return $this->redirectToRoute('office_appointments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('office_appointments/new.html.twig', [
            'office_appointment' => $officeAppointment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/newfromcalendar/{date}/{time}/{staffId}", name="office_appointments_new_from_calendar", methods={"GET", "POST"})
     */
    public function newfromcalendar(request $request, string $date, int $time, int $staffId, OfficeAppointmentsRepository $officeAppointmentsRepository, UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('referer');
        $staff = $userRepository->find($staffId);
        $officeAppointment = new OfficeAppointments();
        $officeAppointment->setStaff($staff)
            ->setDate(new \DateTime($date))
            ->setTime($time);
        $manager->persist($officeAppointment);
        $manager->flush();
        return $this->redirect($referer);
    }


    /**
     * @Route("/newfromdashboard/{id}/", name="employee_calendar_new_from_dashboard", methods={"GET","POST"})
     */
    public function newfromdashboard(int $id, OfficeAppointmentsRepository $officeAppointmentsRepository, EmployeeCalendarSetUpRepository $employeeCalendarSetUpRepository, EntityManagerInterface $manager): Response
    {
        $session = $employeeCalendarSetUpRepository->find($id);
        $startDate = $session->getStartDate();
        $endDate = $session->getEndDate();
        $startTime = (int)$session->getStartTime();
        $endTime = (int)$session->getEndTime();
        $employee = $session->getEmployee();
        $days_difference = $startDate->diff($endDate);
        $number_of_days = $days_difference->days;
        $date_start = new \DateTime($startDate->format('y-m-d'));
        $days_name = $session->getDayOfWeek();
        $dates_container = [];
        $time_container = [];

        for ($j = $startTime; $j <= $endTime; $j++) {
            $time_container[] = $j;
        }
        for ($i = 0; ($i - 1) < $number_of_days; $i++) {
            $date = new \DateTime($date_start->format('y-m-d'));
            if (in_array($date->format('D'), $days_name)) {
                $dates_container[] = $date;
            }
            $date_start->modify("+1 day");
        }
        foreach ($dates_container as $date) {
            foreach ($time_container as $time) {

                $old_office_appointment_calendar = $officeAppointmentsRepository->findOneBy([
                    'date' => $date,
                    'time' => $time,
                    'staff' => $employee
                ]);
                if ($old_office_appointment_calendar) {
                    continue;
                }
                $officeAppointmentCalendar = new OfficeAppointments();
                $officeAppointmentCalendar->setDate($date);
                $officeAppointmentCalendar->setTime($time);
                $officeAppointmentCalendar->setStaff($employee);
                $manager->persist($officeAppointmentCalendar);
            }
        }
        $manager->flush();
        return $this->redirectToRoute('office_appointments_index');
    }

    /**
     * @Route("/show/{id}", name="office_appointments_show", methods={"GET"})
     */
    public function show(OfficeAppointments $officeAppointment): Response
    {
        return $this->render('office_appointments/show.html.twig', [
            'office_appointment' => $officeAppointment,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="office_appointments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OfficeAppointments $officeAppointment, OfficeAppointmentsRepository $officeAppointmentsRepository, Security $security, EntityManagerInterface $manager): Response
    {
        $mode = 'edit';
        $form = $this->createForm(OfficeAppointmentsType::class, $officeAppointment,
            ['mode' => $mode, 'client_id' => $officeAppointment->getClient()->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $referer = $request->request->get('referer');
            $officeAppointmentsRepository->add($officeAppointment, true);
            return $this->redirect($referer);
        }
        return $this->renderForm('office_appointments/edit.html.twig', [
            'office_appointment' => $officeAppointment,
            'form' => $form,
        ]);

    }


    /**
     * @Route("/add_client_to_office_appointment_slot/{id}/{clientId}", name="office_appointments_add_client", methods={"GET", "POST"})
     */
    public function addClientToOfficeAppointment(Request $request, int $clientId, int $id, OfficeAppointments $officeAppointments, UserRepository $userRepository, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('referer');
        $client = $userRepository->find($clientId);
        $officeAppointments->setClient($client);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/switch/{id}/{recipient}", name="office_appointments_switch", methods={"GET", "POST"})
     */
    public function switchStaffMember(int $recipient, Request $request, OfficeAppointments $officeAppointment, OfficeAppointmentsRepository $officeAppointmentsRepository, Security $security, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('referer');
        $swap_office_appointment = $officeAppointmentsRepository->find($recipient);
        $swap_office_appointment_client = $swap_office_appointment->getClient();
        $swap_office_appointment->setClient($officeAppointment->getClient());
        $officeAppointment->setClient($swap_office_appointment_client);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/cancel_appointment/{id}", name="office_appointments_cancel_appointment", methods={"GET", "POST"})
     */
    public function cancel(Request $request, int $id, OfficeAppointments $officeAppointment, OfficeAppointmentsRepository $officeAppointmentsRepository, Security $security, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('referer');
        $officeAppointment = $officeAppointmentsRepository->find($id);
        $officeAppointment->setClient(null);
        $manager->flush();
        return $this->redirect($referer);
    }

    /**
     * @Route("/remove_appointment/{id}", name="office_appointments_remove_appointment", methods={"GET", "POST"})
     */
    public function remove(Request $request, int $id, OfficeAppointments $officeAppointment, OfficeAppointmentsRepository $officeAppointmentsRepository, Security $security, EntityManagerInterface $manager): Response
    {
        $referer = $request->headers->get('referer');
        $officeAppointment = $officeAppointmentsRepository->find($id);
        $officeAppointmentsRepository->remove($officeAppointment);
        $manager->flush();

        return $this->redirect($referer);
    }

    /**
     * @Route("/delete/{id}", name="office_appointments_delete", methods={"POST"})
     */
    public function delete(Request $request, OfficeAppointments $officeAppointment, OfficeAppointmentsRepository $officeAppointmentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $officeAppointment->getId(), $request->request->get('_token'))) {
            $officeAppointmentsRepository->remove($officeAppointment, true);
        }

        return $this->redirectToRoute('office_appointments_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/office_appointments_delete_all/", name="office_appointments_delete_all")
     */
    public function deleteAll( OfficeAppointmentsRepository $officeAppointmentsRepository, EntityManagerInterface $manager): Response
    {
        $appointments = $officeAppointmentsRepository->findAll();
        foreach ($appointments as $appointment) {
            $manager->remove($appointment);
        }
        $manager->flush();

        return $this->redirectToRoute('office_appointments_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/ics_file/{officeOrImmigration}/{appointmentId}", name="generate_ics_file")
     */
    public function generateIcs(string $officeOrImmigration, Request $request, int $appointmentId, OfficeAppointmentsRepository $officeAppointmentsRepository, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, CmsRepository $cmsRepository, EmailTemplatesRepository $emailTemplatesRepository, MailerInterface $mailer, EntityManagerInterface $manager)
    {
        $now = new \DateTime('now');
        $cms = $cmsRepository->find('1');
        $companyName = $cms->getCompanyName();
        $officeAddressURL = "https://immigrationservices.atts-systems.com/businessaddress";

        $officeAddressStreet = $cms->getCompanyAddress();
        $officeAddressCity = $cms->getCompanyAddressCity();
        $officeAddressPostalCode = $cms->getCompanyAddressPostalCode();

        $immigrationAddressURL = "https://immigrationservices.atts-systems.com/immigration_pathos_address";
        $officeAddressComplete = $officeAddressStreet . ', ' . $officeAddressCity . $officeAddressPostalCode;
        $immigrationAddressComplete = "2nd floor, Eleftheriou Venizelou 22, Corner of Eleftheriou Venizelou Ave. & Kaniggos Street, Paphos 8021";

        if ($officeOrImmigration == 'office') {
            $appointment = $officeAppointmentsRepository->find($appointmentId);
            $emailTemplate = $emailTemplatesRepository->findOneBy([
                'name' => 'Office Appointment'
            ]);
            $addressComplete = $officeAddressComplete;
            $officeOrCompany = $companyName;
            $officeOrCompanyURL = $officeAddressURL;
            $staffMember = $appointment->getStaff();
            $body = $this->renderView('emails/officeMeetingConfirmation.html.twig', [
                'template' => $emailTemplatesRepository->findOneBy([
                    'name' => 'Office Appointment'
                ]),
                'appointment' => $appointment,
                'cms' => $cmsRepository->find('1')
            ]);
        } else {
            $appointment = $immigrationAppointmentsRepository->find($appointmentId);
            $emailTemplate = $emailTemplatesRepository->findOneBy([
                'name' => 'Immigration Office Appointment'
            ]);
            $addressComplete = $immigrationAddressComplete;
            $officeOrCompany = 'Pathos Immigration Office';
            $officeOrCompanyURL = $immigrationAddressURL;
            $staffMember = $appointment->getChaperone();
            $body = $this->renderView('emails/immigrationOfficeMeetingConfirmation.html.twig', [
                'template' => $emailTemplatesRepository->findOneBy([
                    'name' => 'Immigration Office Appointment'
                ]),
                'appointment' => $appointment,
                'cms' => $cmsRepository->find('1')
            ]);
        }

        $appointment->setCalendarInvite('Sent at ' . $now->format('d-M-Y h:i'));
        $manager->flush();

        $client = $appointment->getClient();
        $clientEmail = $appointment->getClient()->getEmail();
        $date = $appointment->getDate();
        $time = $appointment->getTime();
        $startDateTime = $date->format('Y-m-d') . " " . $time . ":00";
        $endDateTime = $date->format('Y-m-d') . " " . ($time + 1) . ":00";
        $subjectTemplate = $emailTemplate->getSubject();
        $subject = $subjectTemplate . $date->format('d-M-y') . 'at ' . $time . ':00h';


        $location = new Location();
        $location->setName($addressComplete)
            ->setUri('https://google.com')
            ->setLanguage('en');

        $eventOne = new CalendarEvent();
        $eventOne
            ->setStart(new \DateTime($startDateTime))
            ->setEnd(new \DateTime($endDateTime))
            ->setSummary($subject)
            ->setLocations([$location])
            ->setDescription($body)
            ->setUid('event-uid');

        $attendee = new Attendee(new Formatter());
        $attendee->setValue($clientEmail)
            ->setName($client->getFullName());
        $eventOne->addAttendee($attendee);

        $organizer = new Organizer(new Formatter());
        if ($staffMember) {
            $organizer->setValue($staffMember->getEmail())
                ->setName($staffMember->getFullName())
                ->setLanguage('en');
        }

        $eventOne->setOrganizer($organizer);
        $calendar = new Calendar();
        $calendar->setProdId('-//My Company//Cool Calendar App//EN')
            ->addEvent($eventOne);

        $calendarExport = new CalendarExport(new CalendarStream(), new Formatter());
        $calendarExport->addCalendar($calendar);
        $summary = '';
        $senderEmail = 'nurse_stephen@hotmail.com';
        file_put_contents('calendar.ics', $calendarExport->getStream());
        $email = (new Email())
            ->to('sjwn71@gmail.com')
            ->bcc('sjwn71@gmail.com')
            ->subject($subject)
            ->from($senderEmail)
            ->html($body)
            ->attachFromPath('calendar.ics');
        $mailer->send($email);

        $emails = new Emails();
        $emails->setClient($client)
            ->setDateTime($now)
            ->setSubject($subject)
            ->setBody($body)
            ->setRecipientEmail($clientEmail)
            ->setRecipientName($client->getFullName())
            ->setSender('sjwn71@gmail.com');
        $manager->persist($emails);
        $manager->flush();
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

}
