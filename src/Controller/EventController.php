<?php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

class EventController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/events', name: 'event_index')]
    public function index(): Response
    {
        $events = $this->entityManager->getRepository(Event::class)->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/events/{id}', name: 'event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/events/{id}/booking', name: 'event_booking')]
    public function booking(Event $event): Response
    {
        // Logique de réservation à ajouter ici

        return $this->render('event/booking.html.twig', [
            'event' => $event,
        ]);
    }

    // PARTIT RESERVATION
    /**
     * @Route("/reservation/new/{event_id}", name="reservation_new")
     */
    // public function new(Request $request, Event $event): Response
    // {
    //     if ($request->isMethod('POST')) {
    //         // Handle the reservation logic here

    //         return $this->redirectToRoute('reservation_success');
    //     }

    //     return $this->render('reservation/new.html.twig', [
    //         'event' => $event,
    //         'payment_modes' => ['Credit Card', 'Paypal', 'Bank Transfer'], // Example modes of payment
    //     ]);
    // }
}
