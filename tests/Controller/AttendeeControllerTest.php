<?php

namespace App\Tests\Controller;

use App\Entity\Attendee;
use App\Entity\Student;
use App\Entity\Trip;
use App\Repository\AttendeeRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttendeeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AttendeeRepository $repository;
    private StudentRepository $studentRepository;

    private string $path = '/attendee/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Attendee::class);
        $this->studentRepository = (static::getContainer()->get('doctrine'))->getRepository(Student::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $user = $this->studentRepository->findOneById(5);
        $this->client->loginUser($user);
        $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
    }

    public function testIndexAsStudent(): void
    {
        $user = $this->studentRepository->findOneById(3);
        $this->client->loginUser($user);
        $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(303);
    }
}
