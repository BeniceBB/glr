<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trip")
 */
class TripController extends AbstractController
{
    /**
     * @Route("/", name="app_trip_index", methods={"GET"})
     */
    public function index(TripRepository $tripRepository): Response
    {
        if($this->getUser()->getFirstname() === 'Admin') {
            return $this->render('trip/index.html.twig', [
                'trips' => $tripRepository->findAll(),
            ]);
        }
        else{
            return $this->render('index.html.twig');
        }
    }

    /**
     * @Route("/overview", name="app_trip_overview", methods={"GET"})
     */
    public function overview(TripRepository $tripRepository): Response
    {
        return $this->render('trip/overview.html.twig', [
            'trips' => $tripRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_trip_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TripRepository $tripRepository): Response
    {
        if($this->getUser()->getFirstname() === 'Admin') {
            $trip = new Trip();
            $form = $this->createForm(TripType::class, $trip);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tripRepository->add($trip, true);

                return $this->redirectToRoute('app_trip_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('trip/new.html.twig', [
                'trip' => $trip,
                'form' => $form,
            ]);
        }
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/{id}", name="app_trip_show", methods={"GET"})
     */
    public function show(Trip $trip): Response
    {
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_trip_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Trip $trip, TripRepository $tripRepository): Response
    {
        if($this->getUser()->getFirstname() === 'Admin') {
            $form = $this->createForm(TripType::class, $trip);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $tripRepository->add($trip, true);

                return $this->redirectToRoute('app_trip_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('trip/edit.html.twig', [
                'trip' => $trip,
                'form' => $form,
            ]);
        }
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/{id}", name="app_trip_delete", methods={"POST"})
     */
    public function delete(Request $request, Trip $trip, TripRepository $tripRepository): Response
    {
        if($this->getUser()->getFirstname() === 'Admin') {
            if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->request->get('_token'))) {
            $tripRepository->remove($trip, true);
        }
            return $this->redirectToRoute('app_trip_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('index.html.twig');
    }
}
