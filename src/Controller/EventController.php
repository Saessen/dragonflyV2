<?php

namespace App\Controller;

use App\Entity\Entreprise;


use App\Entity\User;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository, UserRepository $userRepository): Response
    {

        $user = $this->getUser();

        // $events = $user->getEvents();
        // $entreprise = $events->getEntreprise();

        // $user = $this->getUser();
        // $events = $user->getEvents();
        // $events = $eventRepository->findOneBy($user);

        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findBy(["entreprise" => $user->getEntreprise()]),
            // 'events' => $eventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/event/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        // dd($user);
        // 
        $entreprise = $user->getEntreprise();
        // 
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user->setUsername($user);
            // 
            $event->setEntreprise($entreprise);
            // 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
    /**
    * @Route("event/detail/{id}", name="event_detail")
    */
    public function detailFront($id,EventRepository $eventRepository):Response{
        return $this->render("event/detail.html.twig",[
            'event' => $eventRepository->find($id)
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
    /**
     * @Route("/event/desinscription/{id}", name= "event_desinscription")
     */
    public function desinscription($id, EventRepository $eventRepository){
        $event = $eventRepository->find($id);
        $event->removeUser($this->getUser());
        $em = $this->getDoctrine()->getManager();
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute("user_showEvent");
    }

    /**
     * @Route("/event/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/{id}", name="event_delete", methods={"POST"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }
}
