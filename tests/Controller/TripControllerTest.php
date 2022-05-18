<?php

namespace App\Tests\Controller;

use App\Entity\Student;
use App\Entity\Trip;
use App\Repository\TripRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TripControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TripRepository $repository;
    private StudentRepository $studentRepository;
    private string $path = '/trip/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Trip::class);
        $this->studentRepository = (static::getContainer()->get('doctrine'))->getRepository(Student::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        // User 5 is Admin
        $user = $this->studentRepository->findOneById(5);
        $this->client->loginUser($user);
        $this->client->request('GET', $this->path);
        self::assertResponseStatusCodeSame(200);
    }

    public function testNew(): void
    {
        $user = $this->studentRepository->findOneById(5);
        $this->client->loginUser($user);
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Opslaan', [
            'trip[title]' => 'Testing',
            'trip[destination]' => 'Testing',
            'trip[description]' => 'Testing',
            'trip[maxStudents]' => '5',
        ]);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $user = $this->studentRepository->findOneById(3);
        $this->client->loginUser($user);

        $fixture = new Trip();
        $fixture->setTitle('My Title');
        $fixture->setDestination('My Title');
        $fixture->setDescription('My Title');
        $fixture->setStartdate(new \DateTime());
        $fixture->setEnddate(new \DateTime());
        $fixture->setMaxStudents('5');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
    }

    public function testEdit(): void
    {
        $user = $this->studentRepository->findOneById(5);
        $this->client->loginUser($user);

        $fixture = new Trip();
        $fixture->setTitle('Something New');
        $fixture->setDestination('Something New');
        $fixture->setDescription('Something New');
        $fixture->setStartdate(new \DateTime());
        $fixture->setEnddate(new \DateTime());
        $fixture->setMaxStudents('5');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'trip[title]' => 'Something New',
            'trip[destination]' => 'Something New',
            'trip[description]' => 'Something New',
        ]);

        self::assertResponseRedirects('/trip/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDestination());
        self::assertSame('Something New', $fixture[0]->getDescription());
      ;
    }

    public function testEditNoAdmin(): void
    {
        $user = $this->studentRepository->findOneById(3);
        $this->client->loginUser($user);

        $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(303);
    }
}
