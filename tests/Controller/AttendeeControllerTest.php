<?php

namespace App\Tests\Controller;

use App\Entity\Attendee;
use App\Repository\AttendeeRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttendeeControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AttendeeRepository $repository;
    private string $path = '/attendee/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Attendee::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Attendee index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'attendee[identity]' => 'Testing',
            'attendee[student]' => 'Testing',
            'attendee[trip]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Attendees();
        $fixture->setIdentity('My Title');
        $fixture->setStudent('My Title');
        $fixture->setTrip('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Attendee');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Attendee();
        $fixture->setIdentity('My Title');
        $fixture->setStudent('My Title');
        $fixture->setTrip('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'attendee[identity]' => 'Something New',
            'attendee[student]' => 'Something New',
            'attendee[trip]' => 'Something New',
        ]);

        self::assertResponseRedirects('/attendees/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdentity());
        self::assertSame('Something New', $fixture[0]->getStudent());
        self::assertSame('Something New', $fixture[0]->getTrip());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Attendees();
        $fixture->setIdentity('My Title');
        $fixture->setStudent('My Title');
        $fixture->setTrip('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/attendees/');
        self::assertSame(0, $this->repository->count([]));
    }
}
