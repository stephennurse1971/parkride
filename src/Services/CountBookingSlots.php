<?php

namespace App\Services;


use App\Repository\OfficeAppointmentsRepository;


class CountBookingSlots
{
    public function bookingSlots(\DateTimeInterface $date, int $time)
    {
        $all_booking_slots = $this->officeAppointmentsRepository->findAll();
        $booking_slots = [];
        foreach ($all_booking_slots as $booking_slot) {
            if ($booking_slot->getDate() == $date and $booking_slot->getTime() == $time and $booking_slot->getClient() == null) {
                $booking_slots[] = $booking_slot;
            }
        }

        if ($booking_slots) {
            return count($booking_slots);
        } else {
            return count($booking_slots);
        }
    }

    public function findBookingId(\DateTimeInterface $date, int $time)
    {
        $all_booking_slots = $this->officeAppointmentsRepository->findAll();

        foreach ($all_booking_slots as $booking_slot) {
            if ($booking_slot->getDate() == $date and $booking_slot->getTime() == $time and $booking_slot->getClient() == null) {
                return $booking_slot->getId();
            }
        }

       return null;
    }



    public function __construct(OfficeAppointmentsRepository $officeAppointmentsRepository)
    {
        $this->officeAppointmentsRepository = $officeAppointmentsRepository;
    }
}