<?php

namespace App\Services;

use App\Repository\ServicesOfferedRepository;

class ServicesOffered
{
    public function getServicesOffered()
    {
        return $this->servicesOfferedRepository->findAll();
    }

    public function getServicesOfferedFooter()
    {
        return $this->servicesOfferedRepository->findBy([
            'includeInFooter'=>'1'
        ]);
    }
    public function __construct(ServicesOfferedRepository $servicesOfferedRepository)
    {
        $this->servicesOfferedRepository = $servicesOfferedRepository;
    }
}