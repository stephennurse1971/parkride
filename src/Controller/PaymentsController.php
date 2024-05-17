<?php

namespace App\Controller;

use App\Entity\Payments;
use App\Form\PaymentsType;
use App\Repository\PaymentsRepository;
use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/payments")
 */
class PaymentsController extends AbstractController
{
    /**
     * @Route("/{transactionId}", name="payments_index", methods={"GET"},defaults={"transactionId"=NULL})
     */
    public function index(Request $request, $transactionId, PaymentsRepository $paymentsRepository, TransactionRepository $transactionRepository, UserRepository $userRepository, Security $security): Response
    {
        $title = null;
        $payments = [];
        if (in_array('ROLE_CLIENT', $security->getUser()->getRoles())) {
            $title = $security->getUser()->getFullName();
            $transactions = $transactionRepository->findBy([
                'client' => $security->getUser()
            ]);
            foreach ($transactions as $transaction) {
                $payment = $paymentsRepository->findOneBy([
                    'transaction' => $transaction
                ]);

                if ($payment) {
                    $payments[] = $payment;
                }
            }
        } else {
            if ($transactionId) {
                $payments = $paymentsRepository->findBy([
                    'transaction' => $transactionId
                ]);
                $title = 'Transaction ' . $transactionId;
            } else {
                $payments = $paymentsRepository->findAll();
                $title = 'All';
            }
        }


        return $this->render('payments/index.html.twig', [
            'payments' => $payments,
            'title' => $title,
        ]);
    }

    /**
     * @Route("/new/{transactionId}/{balanceOwed}", name="payments_new", methods={"GET", "POST"},defaults={"transactionId"=NULL, "balanceOwed" =NULL})
     */
    public function new(Request $request, int $transactionId, $balanceOwed, PaymentsRepository $paymentsRepository, TransactionRepository $transactionRepository): Response
    {
        $now = new \DateTime('now');
        $payment = new Payments();
        $transaction = $transactionRepository->find($transactionId);
        $form = $this->createForm(PaymentsType::class, $payment, ['transaction' => $transaction, 'balancedOwed' => $balanceOwed]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment->setTransaction($transaction);
            $payment->setAmount($balanceOwed);
            $payment->setDate($now | date_format('y-m-d'));
            $paymentsRepository->add($payment, true);
            return $this->redirectToRoute('payments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payments/new.html.twig', [
            'payment' => $payment,
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payments_show", methods={"GET"})
     */
    public function show(Payments $payment): Response
    {
        return $this->render('payments/show.html.twig', [
            'payment' => $payment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payments_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Payments $payment, PaymentsRepository $paymentsRepository): Response
    {
        $form = $this->createForm(PaymentsType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentsRepository->add($payment, true);

            return $this->redirectToRoute('payments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payments/edit.html.twig', [
            'payment' => $payment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payments_delete", methods={"POST"})
     */
    public function delete(Request $request, Payments $payment, PaymentsRepository $paymentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $payment->getId(), $request->request->get('_token'))) {
            $paymentsRepository->remove($payment, true);
        }

        return $this->redirectToRoute('payments_index', [], Response::HTTP_SEE_OTHER);
    }
}
