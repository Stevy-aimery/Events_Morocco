<?php
// src/Controller/EventController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Form\EventFormType;
use App\Repository\CategoryRepository;


class EventController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/events', name: 'event_index')]
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $titre = $request->query->get('titre', '');
        $dateDebut = $request->query->get('dateDebut', '');
        $lieu = $request->query->get('lieu', '');
        $capacite = $request->query->get('capacite', '');
        
        $events = $eventRepository->searchevents($titre, $dateDebut, $lieu, $capacite);
        
        return $this->render('event/index.html.twig', [
            'events' => $events, 
        ]);
    }
    

    // PARTIT DETAIL EVENT OF TRESOR
    #[Route('/events/{id}', name: 'event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
    // PARTIT RESERVATION OF TRESOR
    #[Route('/events/{id}/booking', name: 'event_booking')]
    public function booking(Event $event): Response
    {
        return $this->render('event/booking.html.twig', [
            'event' => $event,
        ]);
    }

   
}
