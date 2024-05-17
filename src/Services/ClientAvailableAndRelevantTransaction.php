<?php

namespace App\Services;

use App\Repository\ClientAvailabilityRepository;
use App\Repository\ServicesOfferedRepository;
use App\Repository\TransactionRepository;

class ClientAvailableAndRelevantTransaction
{
    public function getClientAvailableAndRelevantTransaction(\DateTimeInterface $date)
    {
        $transactions = [];
        $servicesOffered =$this->servicesOfferedRepository->findBy([
            'requiresImmigrationAppointment'=>1
        ]);
        foreach ($servicesOffered as $service){
            foreach ($this->transactionRepository->findAll() as $transaction){
                if($transaction->getService() == $service){
                    $transactions[] = $transaction;
                }
            }
        }

        $available_clients = $this->clientAvailabilityRepository->findBy([
            'available' => '1',
            'date' => $date
        ]);
        $joint_list = [];
        foreach ($transactions as $transaction) {
            foreach ($available_clients as $available_client) {
                if ($available_client->getClient() == $transaction->getClient() and $transaction->getStatus()=="Pending") {
                    $joint_list[] = $transaction->getClient();
                }
            }
        }
        if ($joint_list) {
            return $joint_list;
        } else {
            return $joint_list;
        }
    }

    public function __construct(TransactionRepository $transactionRepository, ClientAvailabilityRepository $clientAvailabilityRepository, ServicesOfferedRepository $servicesOfferedRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->clientAvailabilityRepository = $clientAvailabilityRepository;
        $this->servicesOfferedRepository = $servicesOfferedRepository;
    }
}