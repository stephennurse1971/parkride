<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\TransactionRepository;

class CountTransactions
{
    public function countTransactions(User $user = null, string $status)
    {
        $pending_transactions = [];
        if ($user) {
            $pending_transactions = $this->transactionRepository->findBy([
                'status' => $status,
                'client' => $user
            ]);
        } else {
            $pending_transactions = $this->transactionRepository->findBy([
                'status' => $status,
            ]);
        }

        return count($pending_transactions);

    }

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
}