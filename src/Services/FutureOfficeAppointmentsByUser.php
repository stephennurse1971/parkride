<?php

namespace App\Services;
use App\Entity\User;
use App\Repository\OfficeAppointmentsRepository;

class FutureOfficeAppointmentsByUser
{
    public function getAppointments(User $user = null, \DateTimeInterface $startDate = null, \DateTimeInterface $endDate = null)
    {
        $today = new \DateTime('now');
        $bookings = $this->officeAppointmentsRepository->findBy([
            'client' => $user
        ]);
        $future_bookings = [];
        if ($startDate == null && $endDate == null) {
            foreach ($bookings as $booking) {
                if ($today->format('y-m-d') <= $booking->getDate()->format('y-m-d')) {
                    $future_bookings[] = $booking;
                }
            }
        }
        if ($startDate != null && $endDate == null) {
            foreach ($bookings as $booking) {
                if ($startDate->format('y-m-d') <= $booking->getDate()->format('y-m-d')) {
                    $future_bookings[] = $booking;
                }
            }
        }
        if ($startDate == null && $endDate != null) {
            foreach ($bookings as $booking) {
                if ($endDate->format('y-m-d') >= $booking->getDate()->format('y-m-d')) {
                    $future_bookings[] = $booking;
                }
            }
        }
        if ($startDate != null && $endDate != null) {
            foreach ($bookings as $booking) {
                if ($startDate->format('y-m-d') <= $booking->getDate()->format('y-m-d') && $endDate->format('y-m-d') > $booking->getDate()->format('y-m-d')) {
                    $future_bookings[] = $booking;
                }
            }
        }

        if ($future_bookings) {
            return count($future_bookings);
        } else {
            return count($future_bookings);
        }

    }

    public function __construct(OfficeAppointmentsRepository $officeAppointmentsRepository)
    {
        $this->officeAppointmentsRepository = $officeAppointmentsRepository;
    }
}