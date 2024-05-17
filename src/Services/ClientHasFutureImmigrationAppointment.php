<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\ImmigrationAppointmentsRepository;
use App\Repository\UserRepository;

class ClientHasFutureImmigrationAppointment
{
    public function getClientAvailableAndRelevantTransaction(int $user)
    {
        $today = new \DateTime('now');
        $client = $this->userRepository->find($user);
        $future_immigration_appointments = $this->immigrationAppointmentsRepository->findBy([
            'client' => $client
        ]);
        $future_appointments_list = [];

        foreach ($future_immigration_appointments as $future_immigration_appointment) {
            if ($future_immigration_appointment->getDate() >= $today){
                $future_appointments_list[] = $future_immigration_appointment;
            }
        }


        if ($future_appointments_list) {
            return true;
        } else {
            return false;
        }
    }

    public function __construct(ImmigrationAppointmentsRepository $immigrationAppointmentsRepository, UserRepository $userRepository)
    {
        $this->immigrationAppointmentsRepository = $immigrationAppointmentsRepository;
        $this->userRepository = $userRepository;
    }
}