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
        $crawler = $this->client->request('GET', $this->path);
        $user = $this->studentRepository->findOneById(3);
        $this->client->loginUser($user);

        self::assertResponseStatusCodeSame(200);
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'trip[title]' => 'Testing',
            'trip[location]' => 'Testing',
            'trip[description]' => 'Testing',
            'trip[startdate]' => 'Testing',
            'trip[enddate]' => 'Testing',
            'trip[maxStudents]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Trip();
        $fixture->setTitle('My Title');
        $fixture->setLocation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setStartdate('My Title');
        $fixture->setEnddate('My Title');
        $fixture->setMaxStudents('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Trip');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Trip();
        $fixture->setTitle('My Title');
        $fixture->setLocation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setStartdate('My Title');
        $fixture->setEnddate('My Title');
        $fixture->setMaxStudents('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'trip[title]' => 'Something New',
            'trip[location]' => 'Something New',
            'trip[description]' => 'Something New',
            'trip[startdate]' => 'Something New',
            'trip[enddate]' => 'Something New',
            'trip[maxStudents]' => 'Something New',
        ]);

        self::assertResponseRedirects('/trip/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getStartdate());
        self::assertSame('Something New', $fixture[0]->getEnddate());
        self::assertSame('Something New', $fixture[0]->getMaxStudents());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Trip();
        $fixture->setTitle('My Title');
        $fixture->setLocation('My Title');
        $fixture->setDescription('My Title');
        $fixture->setStartdate('My Title');
        $fixture->setEnddate('My Title');
        $fixture->setMaxStudents('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/trip/');
        self::assertSame(0, $this->repository->count([]));
    }
}
