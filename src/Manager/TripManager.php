<?php


namespace App\Manager;

use App\Repository\AttendeeRepository;
use App\Repository\TripRepository;

class TripManager
{
    private TripRepository $tripRepository;
    private AttendeeRepository $attendeeRepository;

    public function __construct(TripRepository $tripRepository, AttendeeRepository $attendeeRepository)
    {
        $this->tripRepository = $tripRepository;
        $this->attendeeRepository = $attendeeRepository;
    }

    public function isBooked(string $studentNumber): array
    {
        // Maak een array van de benodigde variabelen om de resultaten van alle reizen te kunnen returnen
        $amount = [];
        $alreadyBooked = [];
        $fullyBooked = [];
        $available = [];

        // Haal alle reizen op
        $trips = $this->tripRepository->findAll();

        // Check voor alle reizen of deze vol zit of al geboekt is
        foreach($trips as $trip) {
            $id = $trip->getId();
            $maxStudents = $trip->getMaxStudents();
            $attendees = $this->attendeeRepository->findByTrip($id);

            // Check of deze reis al geboekt is door de ingelogde student
            $alreadyBooked[$id] = false;
            foreach ($attendees as $attendee) {
                if ($attendee->getStudent()->getStudentNumber() === $studentNumber) {
                    $alreadyBooked[$id] = true;
                }
            }

            // Tel het aantal inschrijvingen en vergelijk deze met elkaar
            $amount[$id] = count($attendees);
            $fullyBooked[$id] = false;
            if ($maxStudents <= $amount[$id] && $maxStudents !== null) {
                $fullyBooked[$id] = true;
            }

            // Aantal plaatsen beschikbaar:
            $available[$id] = $maxStudents - $amount[$id];
        }

        return [
            'amountBooked' => $amount,
            'fullyBooked' => $fullyBooked,
            'alreadyBooked' => $alreadyBooked,
            'available' => $available,
        ];
    }

    public function isBookedByTrip(string $studentNumber, int $id): array
    {
        $trip = $this->tripRepository->findOneById($id);
        $maxStudents = $trip->getMaxStudents();
        $attendees = $this->attendeeRepository->findByTrip($id);

        $alreadyBooked = false;
        $attendeeId = 0;
        foreach ($attendees as $attendee) {
            if ($attendee->getStudent()->getStudentNumber() === $studentNumber) {
                $alreadyBooked = true;
                $attendeeId = $attendee->getId();
            }
        }

        $amount = count($attendees);
        $fullyBooked = false;
        if ($maxStudents <= $amount && $maxStudents !== null) {
            $fullyBooked = true;
        }

        $available = $maxStudents - $amount;

        return [
            'amountBooked' => $amount,
            'fullyBooked' => $fullyBooked,
            'alreadyBooked' => $alreadyBooked,
            'available' => $available,
            'attendeeId' => $attendeeId,
        ];
    }
}