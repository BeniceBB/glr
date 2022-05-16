<?php

namespace App\Controller;

use App\Entity\Attendees;
use App\Form\AttendeesType;
use App\Repository\AttendeesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/attendees')]
class AttendeesController extends AbstractController
{
    #[Route('/', name: 'app_attendees_index', methods: ['GET'])]
    public function index(AttendeesRepository $attendeesRepository): Response
    {
        return $this->render('attendees/index.html.twig', [
            'attendees' => $attendeesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_attendees_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AttendeesRepository $attendeesRepository): Response
    {
        $attendee = new Attendees();
        $form = $this->createForm(AttendeesType::class, $attendee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attendeesRepository->add($attendee, true);

            return $this->redirectToRoute('app_attendees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attendees/new.html.twig', [
            'attendee' => $attendee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attendees_show', methods: ['GET'])]
    public function show(Attendees $attendee): Response
    {
        return $this->render('attendees/show.html.twig', [
            'attendee' => $attendee,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_attendees_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Attendees $attendee, AttendeesRepository $attendeesRepository): Response
    {
        $form = $this->createForm(AttendeesType::class, $attendee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attendeesRepository->add($attendee, true);

            return $this->redirectToRoute('app_attendees_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('attendees/edit.html.twig', [
            'attendee' => $attendee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_attendees_delete', methods: ['POST'])]
    public function delete(Request $request, Attendees $attendee, AttendeesRepository $attendeesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attendee->getId(), $request->request->get('_token'))) {
            $attendeesRepository->remove($attendee, true);
        }

        return $this->redirectToRoute('app_attendees_index', [], Response::HTTP_SEE_OTHER);
    }
}
