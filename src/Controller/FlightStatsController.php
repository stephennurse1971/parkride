<?php

namespace App\Controller;

use App\Entity\FlightStats;
use App\Form\FlightStatsType;
use App\Repository\FlightDestinationsRepository;
use App\Repository\FlightStatsRepository;
use App\Repository\SettingsRepository;
use App\Repository\TennisCourtAvailabilityRepository;
use App\Services\FlightPrice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flight/stats")
 */
class FlightStatsController extends AbstractController
{
    /**
     * @Route("/", name="flight_stats_index", methods={"GET"})
     */
    public function index(FlightStatsRepository $flightStatsRepository,FlightDestinationsRepository $flightDestinationsRepository, SettingsRepository $settingsRepository): Response
    {
        $flightDestinations = $flightDestinationsRepository->findAll();
        $date = new \DateTime('now');
        $month = $date->format('m');
        $year = $date->format('Y');
        $dates = [];
        $sixth_month = $month + 6;

        if ($sixth_month > 12) {
            $sixth_month = $sixth_month - 12;
            $year = $year + 1;
        }
        $first_date_of_sixth_month = "01-" . $sixth_month . "-" . $year;
        $new_date = new \DateTime($first_date_of_sixth_month);
        $last_day_of_six_month = $new_date->modify('last day of');
        $current_date = new \DateTime('now');
        while ($current_date <= $last_day_of_six_month) {
            $dates[] = new \DateTime($current_date->format('d-m-Y'));
            $current_date = new \DateTime($current_date->modify("+1 day")->format('d-m-Y'));
        }

        return $this->render('flight_stats/index.html.twig', [
            'flight_destinations' => $flightDestinations,
            'flights' => $flightStatsRepository->findAll(),
            'dates' => $dates,
            'settings' => $settingsRepository->find('1')
        ]);
    }

    /**
     * @Route("/new", name="flight_stats_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $flightStat = new FlightStats();
        $form = $this->createForm(FlightStatsType::class, $flightStat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flightStat);
            $entityManager->flush();

            return $this->redirectToRoute('flight_stats_index');
        }

        return $this->render('flight_stats/new.html.twig', [
            'flight_stat' => $flightStat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flight_stats_show", methods={"GET"})
     */
    public function show(FlightStats $flightStat): Response
    {
        return $this->render('flight_stats/show.html.twig', [
            'flight_stat' => $flightStat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="flight_stats_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FlightStats $flightStat): Response
    {
        $form = $this->createForm(FlightStatsType::class, $flightStat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flight_stats_index');
        }

        return $this->render('flight_stats/edit.html.twig', [
            'flight_stat' => $flightStat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flight_stats_delete", methods={"POST"})
     */
    public function delete(Request $request, FlightStats $flightStat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flightStat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flightStat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flight_stats_index');
    }

    /**
     * @Route("/delete/all", name="flight_stats_delete_all", methods={"GET"})
     */
    public function deleteAll(Request $request, FlightStatsRepository $flightStatsRepository): Response
    {
        $referer = $request->headers->get('referer');
        $allEntries = $flightStatsRepository->findAll();
        foreach ($allEntries as $allEntry) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($allEntry);
            $entityManager->flush();
        }
        return $this->redirect($referer);
    }
    /**
     * @Route("/flight/price/scrape/all", name="house_guests_flight_price_scrape_all")
     */
    public function getPrice(FlightPrice $flightPrice, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $flightPrice->getPrice('all');
        return $this->redirectToRoute('flight_stats_index');
    }

    /**
     * @Route("/flight/price/scrape_one_destination/{id}", name="house_guests_flight_price_scrape_one_destination")
     */
    public function getPriceOne(Request $request, $id, FlightPrice $flightPrice, FlightDestinationsRepository $flightDestinationsRepository): Response
    {
        $flightPrice->getPrice($id);
        return $this->redirectToRoute('flight_stats_index');
    }

}
