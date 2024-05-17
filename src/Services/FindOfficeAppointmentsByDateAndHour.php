<?php

namespace App\Services;

use App\Repository\OfficeAppointmentsRepository;

class FindOfficeAppointmentsByDateAndHour
{
    public function getListOfOfficeAppointmentsByDateAndHour(\DateTimeInterface $date, int $time)
    {
        $all_office_appointments = $this->officeAppointmentsRepository->findBy([
            'date' => $date,
            'time' => $time
        ]);

        if ($all_office_appointments) {
            return $all_office_appointments;
        } else {
            return null;
        }
    }

    public function __construct(OfficeAppointmentsRepository $officeAppointmentsRepository)
    {
        $this->officeAppointmentsRepository = $officeAppointmentsRepository;
    }
}






