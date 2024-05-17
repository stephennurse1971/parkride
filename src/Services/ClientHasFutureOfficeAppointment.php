<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\OfficeAppointmentsRepository;
use App\Repository\UserRepository;

class ClientHasFutureOfficeAppointment
{
    public function getCountOfFutureOfficeAppointments(int $user)
    {
        $today = new \DateTime('now');
        $client = $this->userRepository->find($user);
        $future_office_appointments = $this->officeAppointmentsRepository->findBy([
            'client' => $client
        ]);
        $future_appointments_list = [];

        foreach ($future_office_appointments as $future_office_appointment) {
            if ($future_office_appointment->getDate() >= $today){
                $future_appointments_list[] = $future_office_appointment;
            }
        }


        if ($future_appointments_list) {
            return true;
        } else {
            return false;
        }
    }

    public function __construct(OfficeAppointmentsRepository $officeAppointmentsRepository, UserRepository $userRepository)
    {
        $this->officeAppointmentsRepository = $officeAppointmentsRepository;
        $this->userRepository = $userRepository;
    }
}