<?php

namespace App\Services;

use App\Repository\TransactionRepository;

class ClientsWithPendingTransactions
{
    public function getPendingClientList()
    {
        $pending_clients = [];
        $all_transactions =  $this->transactionRepository->findAllClients();
        foreach ($all_transactions as $transaction) {
            $pending_clients[] = $transaction->getClient();
        }
       $clients_fullName_list = [];

        if ($pending_clients) {
            return array_unique($pending_clients,SORT_REGULAR);
        } else {
            return $pending_clients;
        }
    }

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }
}