<?php

namespace App\Entity;

use App\Repository\AttendeesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AttendeesRepository::class")
 */

class Attendees
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="attendees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trip", inversedBy="attendees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trip;

    /**
     * @ORM\Column(type="integer")
     */
    private $identity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getTrip(): ?Trip
    {
        return $this->trip;
    }

    public function setTrip(?Trip $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getIdentity(): ?int
    {
        return $this->identity;
    }

    public function setIdentity(int $identity): self
    {
        $this->identity = $identity;

        return $this;
    }
}
