<?php

namespace App\Test\Controller;

use App\Entity\Trip;
use App\Manager\TripManager;
use App\Repository\AttendeeRepository;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TripManagerTest extends WebTestCase
{
    public function testIsBooked()
    {
        $tripRepository = $this->createMock(TripRepository::class);
        $attendeeRepository = $this->createMock(AttendeeRepository::class);

        $tripManager = new TripManager($tripRepository, $attendeeRepository);

        $trips = [new Trip(), new Trip()];

        $result = $tripManager->isBooked('79458');
        static::assertFalse($result);
    }
}