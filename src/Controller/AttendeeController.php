<?php

namespace App\Controller;

use App\Entity\Attendee;
use App\Form\AttendeeType;
use App\Repository\AttendeeRepository;
use App\Repository\StudentRepository;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attendee")
 */
class AttendeeController extends AbstractController
{
    /**
     * @Route("/", name="app_attendee_index", methods={"GET"})
     */
    public function index(AttendeeRepository $attendeeRepository): Response
    {
        if($this->getUser()->getFirstname() === 'Admin') {
            return $this->render('attendee/index.html.twig', [
                'attendees' => $attendeeRepository->findAll(),
            ]);
        }
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/book/{tripId}", name="app_attendee_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AttendeeRepository $attendeeRepository, TripRepository $tripRepository, StudentRepository $studentRepository, int $tripId): Response
    {
        $attendee = new Attendee();
        $trip = $tripRepository->findOneById($tripId);
        $student = $studentRepository->findOneById(2);
        $form = $this->createForm(AttendeeType::class, $attendee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attendee->setTrip($trip);
            $attendee->setStudent($student);
            $attendeeRepository->add($attendee, true);
            return $this->redirectToRoute('app_attendee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attendee/new.html.twig', [
            'attendee' => $attendee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attendee_show", methods={"GET"})
     */
    public function show(Attendee $attendee): Response
    {
        return $this->render('attendee/show.html.twig', [
            'attendee' => $attendee,
        ]);
    }

    /**
     * @Route("/{id}", name="app_attendee_delete", methods={"POST"})
     */
    public function delete(Request $request, Attendee $attendee, AttendeeRepository $attendeeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attendee->getId(), $request->request->get('_token'))) {
            $attendeeRepository->remove($attendee, true);
        }

        return $this->redirectToRoute('app_attendee_index', [], Response::HTTP_SEE_OTHER);
    }
}
