<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Form\EventFormType;


class AdminController extends AbstractController
{
  

    #[Route('/admin', name: 'app_admin')]
    public function index(EventRepository $eventRepository): Response
    {
        // Retrieve list of events from the database
        $events = $eventRepository->findAll();
    
        // Create a new event form
         $event = new Event();
         $form = $this->createForm(EventFormType::class, $event);

            return $this->render('admin/dashboard.html.twig', [
                'events' => $events,
                'eventForm' => $form->createView(),
            ]);
    }


    #[Route('/admin/event/create', name: 'event_create')]
        public function create(Request $request, EntityManagerInterface $entityManager): Response
        {
            $event = new Event();
            $form = $this->createForm(EventFormType::class, $event);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($event);
                $entityManager->flush();

                $this->addFlash('success', 'Event created successfully!');

                return $this->redirectToRoute('app_admin'); // Adjust route name as needed
            }

            return $this->render('admin/create.html.twig', [
                'eventForm' => $form->createView(),
            ]);
        }


        #[Route('admin/event/{id}/delete', name: 'event_delete')]
        public function delete(Event $event, EntityManagerInterface $entityManager): Response
        {
            // Check if the event exists
            if (!$event) {
                throw $this->createNotFoundException('Event not found');
            }
        
            // Delete the event from the database
            $entityManager->remove($event);
            $entityManager->flush();
        
            // Add a flash message to indicate successful deletion
            $this->addFlash('success', 'Event deleted successfully');
        
            // Redirect back to the admin dashboard
            return $this->redirectToRoute('app_admin'); // Adjust route name as needed
        }

        #[Route('/event/{id}/edit', name: 'event_edit')]
        public function edit(Event $event, Request $request, EntityManagerInterface $entityManager): Response
        {
            // Check if the event exists
            if (!$event) {
                throw $this->createNotFoundException('Event not found');
            }

            // Create a form pre-filled with the event data
            $form = $this->createForm(EventFormType::class, $event);

            // Handle form submission
            $form->handleRequest($request);

            // Check if the form was submitted and is valid
            if ($form->isSubmitted() && $form->isValid()) {
                // Update the event entity with the form data
                $entityManager->flush();

                // Add a flash message to indicate successful editing
                $this->addFlash('success', 'Event updated successfully');

                // Redirect back to the admin dashboard
                return $this->redirectToRoute('app_admin'); // Adjust route name as needed
            }

            // Render the edit form template
            return $this->render('admin/edit.html.twig', [
                'eventForm' => $form->createView(),
            ]);
        }
}
