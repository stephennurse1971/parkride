<?php

namespace App\Controller;

use App\Entity\YellowPinkSlips;
use App\Form\YellowPinkSlipsType;
use App\Repository\UserRepository;
use App\Repository\YellowPinkSlipsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/yellow/pink/slips")
 */
class YellowPinkSlipsController extends AbstractController
{
    /**
     * @Route("/", name="yellow_pink_slips_index", methods={"GET"})
     */
    public function index(YellowPinkSlipsRepository $yellowPinkSlipsRepository): Response
    {
        return $this->render('yellow_pink_slips/index.html.twig', [
            'yellow_pink_slips' => $yellowPinkSlipsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="yellow_pink_slips_new", methods={"GET", "POST"})
     */
    public function new(Request $request, YellowPinkSlipsRepository $yellowPinkSlipsRepository, UserRepository $userRepository): Response
    {
        $clients = $userRepository->findAll();
        if($request->query->get('client')){
            $client_name = $request->query->get('client');
            $client_name = explode(' ',$client_name);
            $first_name = $client_name[0];
            $last_name = $client_name[1];
            $clients = $userRepository->findBy(['firstName'=>$first_name,'lastName'=>$last_name]);
        }
        $yellowPinkSlip = new YellowPinkSlips();
        $form = $this->createForm(YellowPinkSlipsType::class, $yellowPinkSlip,['clients'=>$clients]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userFullName = $yellowPinkSlip->getRecipient()->getFullName();
            $yellow_pink_slip_directory = $this->getParameter('yellow_pink_slips_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Yellow_Pink_Slip_" . $userFullName . $file->guessExtension();
                $file->move($yellow_pink_slip_directory, $newFilename);
                $yellowPinkSlip->setFile($newFilename);
            }

            $yellowPinkSlipsRepository->add($yellowPinkSlip, true);
            return $this->redirectToRoute('yellow_pink_slips_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('yellow_pink_slips/new.html.twig', [
            'yellow_pink_slip' => $yellowPinkSlip,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="yellow_pink_slips_show", methods={"GET"})
     */
    public function show(YellowPinkSlips $yellowPinkSlip): Response
    {
        return $this->render('yellow_pink_slips/show.html.twig', [
            'yellow_pink_slip' => $yellowPinkSlip,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="yellow_pink_slips_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, YellowPinkSlips $yellowPinkSlip, YellowPinkSlipsRepository $yellowPinkSlipsRepository): Response
    {
        $userFullName = $yellowPinkSlip->getRecipient()->getFullName();
        $form = $this->createForm(YellowPinkSlipsType::class, $yellowPinkSlip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $yellow_pink_slip_directory = $this->getParameter('yellow_pink_slips_attachments_directory');
            $file = $form->get('file')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = "Yellow_Pink_Slip_" . $userFullName . $file->guessExtension();
                $file->move($yellow_pink_slip_directory, $newFilename);
                $yellowPinkSlip->setFile($newFilename);
            }

            $yellowPinkSlipsRepository->add($yellowPinkSlip, true);
            return $this->redirectToRoute('yellow_pink_slips_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('yellow_pink_slips/edit.html.twig', [
            'yellow_pink_slip' => $yellowPinkSlip,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="yellow_pink_slips_delete", methods={"POST"})
     */
    public function delete(Request $request, YellowPinkSlips $yellowPinkSlip, YellowPinkSlipsRepository $yellowPinkSlipsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $yellowPinkSlip->getId(), $request->request->get('_token'))) {
            $yellowPinkSlipsRepository->remove($yellowPinkSlip, true);
        }

        return $this->redirectToRoute('yellow_pink_slips_index', [], Response::HTTP_SEE_OTHER);
    }
}
