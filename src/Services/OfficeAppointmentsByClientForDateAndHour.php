<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\OfficeAppointmentsRepository;

class OfficeAppointmentsByClientForDateAndHour
{
    public function countAppointments(User $user = null, \DateTimeInterface $date, int $time)
    {
        $appointments = $this->officeAppointmentsRepository->findBy([
            'client' => $user,
            'date' => $date,
            'time' => $time
        ]);
        $relevant_appointments = [];
        foreach ($appointments as $appointment) {
            $relevant_appointments[] = $appointment;
        }


        if ($relevant_appointments) {
            return count($relevant_appointments);
        } else {
            return count($relevant_appointments);
        }

    }

    public function __construct(OfficeAppointmentsRepository $officeAppointmentsRepository)
    {
        $this->officeAppointmentsRepository = $officeAppointmentsRepository;
    }
}