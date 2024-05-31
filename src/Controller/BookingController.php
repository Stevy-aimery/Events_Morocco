<?php
// src/Controller/BookingController.php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Event;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BookingController extends AbstractController
{
    #[Route('/reservation/{eventId}', name: 'app_reservation', requirements: ['eventId' => '\d+'])]
public function index(int $eventId, Request $request, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils): Response
{
    // Check if the user is authenticated
    if (!$this->getUser()) {
        // Store the event ID in the session to redirect back after login
        $request->getSession()->set('eventId', $eventId);

        // Redirect to login page
        return $this->redirectToRoute('app_login');
    }

    // Check if the event ID is stored in the session
    $storedEventId = $request->getSession()->get('eventId');
    if ($storedEventId !== null && $storedEventId !== $eventId) {
        // Clear the stored event ID from the session
        $request->getSession()->remove('eventId');

        // Redirect to the reservation form page with the stored event ID
        return $this->redirectToRoute('app_reservation', ['eventId' => $storedEventId]);
    }

    // Proceed with the normal reservation form handling
    $event = $entityManager->getRepository(Event::class)->find($eventId);
    if (!$event) {
        throw $this->createNotFoundException('Event not found');
    }

    $booking = new Booking();
    $booking->setLibelle($event->getTitre());
    $booking->setMontant($event->getPrixBillet());

    $form = $this->createForm(BookingType::class, $booking);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($booking);
        $entityManager->flush();

        // Pass a success message to the template
        return $this->render('reservation/index.html.twig', [
            'bookingForm' => $form->createView(),
            'event' => $event,
            'success' => true,
        ]);
    }

    return $this->render('reservation/index.html.twig', [
        'bookingForm' => $form->createView(),
        'event' => $event,
        'success' => false,
    ]);
}
}
