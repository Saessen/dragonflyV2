<?php

namespace App\Controller;

use App\Entity\Messagerie;
use App\Form\MessagerieType;
use App\Repository\EventRepository;
use App\Repository\MessagerieRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MessagerieController extends AbstractController
{
    /**
     * @Route("/messagerie", name="messagerie_index", methods={"GET"})
     */
    public function index(MessagerieRepository $messagerieRepository): Response
    {
        
        $user = $this->getUser();
        
        // return new Response('hop message');
        return $this->render('messagerie/index.html.twig', [
            'messageries' => $messagerieRepository->findAll(),
        ]);
    }
/////////////////////////////////////////////////////////////////////
    /**
     * @Route("/messagerie/new", name="messagerie_new", methods={"GET","POST"})
     */
    // public function newmessage($id, EventRepository $eventRepository){
    //     $event = $eventRepository->find($id);
    //     $user = $this->getUser();
    //     $user->addEvent($event);
    //     $em = $this->getDoctrine()->getManager();
    //     $em->persist($user);
    //     $em->flush();
    //     //
    //     return new Response("Et hop!!!!");
    // }



    ////////////////////////////////////////////////////////////////
    /**
     * @Route("/new/{id}", name="messagerie_new", methods={"GET","POST"})
     */
    public function new($id,Request $request, EventRepository $eventRepository, MessagerieRepository $messagerieRepository, UserRepository $userRepository): Response
    {   
        // $user = $userRepository->find($id);
        $event = $eventRepository->find($id);
        $messagerie = new Messagerie();
        $messagerie->setEvent($event);
        // $messagerie->setEvent($user);
        $form = $this->createForm(MessagerieType::class, $messagerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $messagerie->setCreatedAt(new \Datetime('now'));
            // $messagerie->setExpediteur($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($messagerie);
            $entityManager->flush();
            $this->addFlash("message", "Message envoyé avec succès");

            // return $this->redirectToRoute('messagerie_index');
        }
        $eventMessages = $messagerieRepository->findBy(["event"=>$id],  ["createdAt"=>"DESC"]);
        return $this->render('messagerie/new.html.twig', [
            'messagerie' => $messagerie,
            'form' => $form->createView(),
            'messages' => $eventMessages
        ]);
    }

    /**
     * @Route("/messagerie/{id}", name="messagerie_show", methods={"GET"})
     */
    public function show(Messagerie $messagerie): Response
    {
        return $this->render('messagerie/show.html.twig', [
            'messagerie' => $messagerie,
        ]);
    }

    /**
     * @Route("/messagerie/{id}/edit", name="messagerie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Messagerie $messagerie): Response
    {
        $form = $this->createForm(MessagerieType::class, $messagerie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('messagerie_index');
        }

        return $this->render('messagerie/edit.html.twig', [
            'messagerie' => $messagerie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/messagerie/{id}", name="messagerie_delete", methods={"POST"})
     */
    public function delete(Request $request, Messagerie $messagerie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$messagerie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($messagerie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('messagerie_index');
    }
}
