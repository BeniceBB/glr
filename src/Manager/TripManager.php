<?php


namespace App\Manager;


use App\Entity\Student;
use App\Entity\Trip;
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
        $amount = [];
        $alreadyBooked = [];
        $fullyBooked = [];
        $available = [];

        $trips = $this->tripRepository->findAll();

        foreach($trips as $trip) {
            $id = $trip->getId();
            $maxStudents = $trip->getMaxStudents();

            $attendees = $this->attendeeRepository->findByTrip($id);
            $alreadyBooked[$id] = false;
            foreach ($attendees as $attendee) {
                if ($attendee->getStudent()->getStudentNumber() === $studentNumber) {
                    $alreadyBooked[$id] = true;
                }
            }

            $amount[$id] = count($attendees);
            $fullyBooked[$id] = false;
            if ($maxStudents <= $amount[$id] && $maxStudents !== null) {
                $fullyBooked[$id] = true;
            }

            $available[$id] = $maxStudents - $amount[$id];
        }

        return [
            'amountBooked' => $amount,
            'fullyBooked' => $fullyBooked,
            'alreadyBooked' => $alreadyBooked,
            'available' => $available,
        ];
    }
}