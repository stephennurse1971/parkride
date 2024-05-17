<?php

namespace App\Controller;

use App\Entity\CarManufacturers;
use App\Form\CarManufacturersType;
use App\Repository\CarManufacturersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car/manufacturers")
 * @Security("is_granted('ROLE_STAFF')")
 */
class CarManufacturersController extends AbstractController
{
    /**
     * @Route("/", name="car_manufacturers_index", methods={"GET"})
     */
    public function index(CarManufacturersRepository $carManufacturersRepository): Response
    {
        return $this->render('car_manufacturers/index.html.twig', [
            'car_manufacturers' => $carManufacturersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="car_manufacturers_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CarManufacturersRepository $carManufacturersRepository): Response
    {
        $carManufacturer = new CarManufacturers();
        $form = $this->createForm(CarManufacturersType::class, $carManufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carManufacturersRepository->add($carManufacturer, true);

            return $this->redirectToRoute('car_manufacturers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car_manufacturers/new.html.twig', [
            'car_manufacturer' => $carManufacturer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_car_manufacturers_show", methods={"GET"})
     */
    public function show(CarManufacturers $carManufacturer): Response
    {
        return $this->render('car_manufacturers/show.html.twig', [
            'car_manufacturer' => $carManufacturer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_car_manufacturers_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CarManufacturers $carManufacturer, CarManufacturersRepository $carManufacturersRepository): Response
    {
        $form = $this->createForm(CarManufacturersType::class, $carManufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carManufacturersRepository->add($carManufacturer, true);

            return $this->redirectToRoute('car_manufacturers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car_manufacturers/edit.html.twig', [
            'car_manufacturer' => $carManufacturer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_car_manufacturers_delete", methods={"POST"})
     */
    public function delete(Request $request, CarManufacturers $carManufacturer, CarManufacturersRepository $carManufacturersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carManufacturer->getId(), $request->request->get('_token'))) {
            $carManufacturersRepository->remove($carManufacturer, true);
        }

        return $this->redirectToRoute('car_manufacturers_index', [], Response::HTTP_SEE_OTHER);
    }
}
