<?php

namespace App\Controller;

use App\Entity\ClientAvailability;
use App\Form\ClientAvailabilityType;
use App\Repository\ClientAvailabilityRepository;
use App\Repository\EmailTemplatesRepository;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/clientavailability")
 */
class ClientAvailabilityController extends AbstractController
{

    /**
     * @Route("/calendar/byclient/{clientFullName}", name="client_availability_by_client", methods={"GET"})
     */
    public function indexByClient(string $clientFullName, ClientAvailabilityRepository $clientAvailabilityRepository, UserRepository $userRepository): Response
    {
        $clientName = explode(' ', $clientFullName);
        $first_name = $clientName[0];
        $last_name = $clientName[1];
        $client = $userRepository->findOneBy([
            'firstName' => $first_name,
            'lastName' => $last_name
        ]);
        return $this->render('client_availability/index.html.twig', [
            'client' => $client,
            'officeOrPIA' =>'PIA',
            'client_availabilities' => $clientAvailabilityRepository->findBy([
                'client' => $client
            ])
        ]);
    }

    /**
     * @Route("/calendar/all_clients", name="client_availability_index", methods={"GET"})
     */
    public function index (ClientAvailabilityRepository $clientAvailabilityRepository, EmailTemplatesRepository $emailTemplatesRepository, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository,TransactionRepository $transactionRepository, Request $request): Response
    {
        $template_id= $emailTemplatesRepository->findOneBy([
            'name' => 'Immigration Office Appointment'
        ]);
        $clientAvailabilities = $clientAvailabilityRepository->findAll();
        $immigrationAppointments = $immigrationAppointmentsRepository->findAll();
        $transactions = $transactionRepository->findAll();
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

        return $this->render('client_availability/indexAll.html.twig', [
            'client_availabilities' => $clientAvailabilities,
            'immigration_appointments' => $immigrationAppointments,
            'template_id'=>$template_id,
            'transactions' => $transactions,
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
            'today' => $today,
            'todayHour' => $todayHour,
            'officeOrPIA' =>'PIA'
        ]);
    }

    /**
     * @Route("/calendar/all_clients_list", name="client_availability_index_list", methods={"GET"})
     */
    public function indexAllList (ClientAvailabilityRepository $clientAvailabilityRepository, ImmigrationAppointmentsRepository $immigrationAppointmentsRepository,TransactionRepository $transactionRepository, Request $request): Response
    {
        $clientAvailabilities = $clientAvailabilityRepository->findAll();
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

        return $this->render('client_availability/indexALLlist.html.twig', [
            'client_availabilities' => $clientAvailabilities,
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
            'today' => $today,
            'todayHour' => $todayHour,
        ]);


        return $this->render('client_availability/indexALLlist.html.twig', [
            'client_availabilities' => $clientAvaibility
        ]);
    }







    /**
     * @Route("/new", name="client_availability_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ClientAvailabilityRepository $clientAvailabilityRepository): Response
    {
        $clientAvailability = new ClientAvailability();
        $form = $this->createForm(ClientAvailabilityType::class, $clientAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientAvailabilityRepository->add($clientAvailability, true);

            return $this->redirectToRoute('client_availability_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_availability/new.html.twig', [
            'client_availability' => $clientAvailability,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="client_availability_show", methods={"GET"})
     */
    public function show(ClientAvailability $clientAvailability): Response
    {
        return $this->render('client_availability/show.html.twig', [
            'client_availability' => $clientAvailability,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="client_availability_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ClientAvailability $clientAvailability, ClientAvailabilityRepository $clientAvailabilityRepository): Response
    {
        $form = $this->createForm(ClientAvailabilityType::class, $clientAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientAvailabilityRepository->add($clientAvailability, true);

            return $this->redirectToRoute('client_availability_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client_availability/edit.html.twig', [
            'client_availability' => $clientAvailability,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/switch_availablity", name="client_availability_switch", methods={"GET", "POST"})
     */
    public function switch(Request $request, int $id, ClientAvailability $clientAvailability, ClientAvailabilityRepository $clientAvailabilityRepository, EntityManagerInterface $manager): Response
    {
        $clientAvailability = $clientAvailabilityRepository->find($id);
        if($clientAvailability->isAvailable() ){
            $clientAvailability->setAvailable('0');
        }
        else{
            $clientAvailability->setAvailable('1');
        }
        $manager->flush();
        return $this->redirect($request->headers->get('Referer'));
    }

    /**
     * @Route("/{id}", name="client_availability_delete", methods={"POST"})
     */
    public function delete(Request $request, ClientAvailability $clientAvailability, ClientAvailabilityRepository $clientAvailabilityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $clientAvailability->getId(), $request->request->get('_token'))) {
            $clientAvailabilityRepository->remove($clientAvailability, true);
        }

        return $this->redirectToRoute('client_availability_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/reset_all/{clientId}", name="client_availability_reset_all")
     */
    public function deleteAll(int $clientId, UserRepository $userRepository,Request $request, ClientAvailabilityRepository $clientAvailabilityRepository,EntityManagerInterface $manager): Response
    {
        $referrer = $request->headers->get('Referer');
        $client_availabilities = $clientAvailabilityRepository->findBy([
            'client'=>$userRepository->find($clientId)
        ]);
        foreach($client_availabilities as $availability){
              $manager->remove($availability);
        }
        $manager->flush();
        return $this->redirect($referrer);
    }

    /**
     * @Route("/ajax/new/", name="client_availability_ajax_new_client_availability", methods={"POST"})
     */
    public function ajaxNewClientAvailability(EntityManagerInterface $entityManager, UserRepository $userRepository, ClientAvailabilityRepository $clientAvailabilityRepository): Response
    {
        $client_id = $_POST['client'];
        $client = $userRepository->find($client_id);
        $date_as_string = $_POST['date'];
        $date = new \DateTime($date_as_string);
        $previous_client_availability = $clientAvailabilityRepository->findOneBy(['date' => $date, 'client' => $client]);
        if ($previous_client_availability) {
            $availability = $previous_client_availability->isAvailable();
            if ($availability) {
                $previous_client_availability->setAvailable(0);
            } else {
                $previous_client_availability->setAvailable(1);
            }
        } else {
            $client_avalability = new ClientAvailability();
            $client_avalability->setDate($date)
                ->setAvailable(1)
                ->setClient($client);
            $entityManager->persist($client_avalability);
        }

        $entityManager->flush();
        return new Response(null);
    }
    /**
     * @Route("/ajax/new/switch", name="client_availability_ajax_new_client_availability_switch", methods={"POST"})
     */
    public function ajaxNewClientAvailabilitySwitch(EntityManagerInterface $entityManager, UserRepository $userRepository, ClientAvailabilityRepository $clientAvailabilityRepository): Response
    {
        $client_id = $_POST['client'];
        $client = $userRepository->find($client_id);
        $date_as_string = $_POST['date'];
        $date = new \DateTime($date_as_string);
        $switch = $_POST['switch'];
        $previous_client_availability = $clientAvailabilityRepository->findOneBy(['date' => $date, 'client' => $client]);

        if ($previous_client_availability) {
            if($switch == 1){
                $previous_client_availability->setAvailable(1);
            }
            else{

                $previous_client_availability->setAvailable(0);
            }
        }
        else {
            $client_avalability = new ClientAvailability();
            if($switch == 1) {
                $client_avalability->setDate($date)
                    ->setAvailable(1)
                    ->setClient($client);
            }
            else{
                $client_avalability->setDate($date)
                    ->setAvailable(0)
                    ->setClient($client);
            }
            $entityManager->persist($client_avalability);
        }

        $entityManager->flush();
        return new Response(null);
    }
}
