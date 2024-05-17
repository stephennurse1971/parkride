<?php

namespace App\Controller;

use App\Entity\Currencies;
use App\Form\CurrenciesType;
use App\Repository\CurrenciesRepository;
use App\Repository\FxRatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/currencies")
 * @Security("is_granted('ROLE_STAFF')")
 */
class CurrenciesController extends AbstractController
{
    /**
     * @Route("/", name="currencies_index", methods={"GET"})
     */
    public function index(CurrenciesRepository $currenciesRepository): Response
    {
        return $this->render('currencies/index.html.twig', [
            'currencies' => $currenciesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="currencies_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CurrenciesRepository $currenciesRepository): Response
    {
        $currency = new Currencies();
        $form = $this->createForm(CurrenciesType::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currenciesRepository->add($currency, true);

            return $this->redirectToRoute('currencies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('currencies/new.html.twig', [
            'currency' => $currency,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="currencies_show", methods={"GET"})
     */
    public function show(Currencies $currency): Response
    {
        return $this->render('currencies/show.html.twig', [
            'currency' => $currency,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="currencies_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Currencies $currency, CurrenciesRepository $currenciesRepository): Response
    {
        $form = $this->createForm(CurrenciesType::class, $currency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currenciesRepository->add($currency, true);

            return $this->redirectToRoute('currencies_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('currencies/edit.html.twig', [
            'currency' => $currency,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="currencies_delete", methods={"POST"})
     */
    public function delete(Request $request, Currencies $currency, CurrenciesRepository $currenciesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$currency->getId(), $request->request->get('_token'))) {
            $currenciesRepository->remove($currency, true);
        }

        return $this->redirectToRoute('currencies_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/ajax/update/currency", name="ajax_update_currency",methods={"POST"})
     */
    public function fxRateUpdate(CurrenciesRepository $currenciesRepository,EntityManagerInterface $manager)
    {
        if(isset($_POST['fx_rate']))
        {
            $rate = $_POST['fx_rate'];
            $fxRate_id = $_POST['fxRate_id'];
            $getFxRateById = $currenciesRepository->find($fxRate_id);
            $getFxRateById->setFxRate($rate);
            $manager->flush();
        }
        return new Response(null);
    }

}
