<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\OfficeAppointmentsRepository;

class FutureOfficeAppointmentsThatAreAvailable
{
    public function countAppointments( \DateTimeInterface $date, int $time)
    {
        $all_appointments = $this->officeAppointmentsRepository->findBy([
            'date' => $date,
            'time' => $time,
            'client'=> null
        ]);
        $bookings = [];

        foreach ($all_appointments as $booking) {
            $bookings[] = $booking;

        }

        if ($bookings) {
            return count($bookings);
        } else {
            return count($bookings);
        }

    }

    public function __construct(OfficeAppointmentsRepository $officeAppointmentsRepository)
    {
        $this->officeAppointmentsRepository = $officeAppointmentsRepository;
    }
}

