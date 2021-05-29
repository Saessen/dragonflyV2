<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/index", name="admin_index", methods={"GET"})
     */
    public function indexAdmin(UserRepository $userRepository): Response
    {
        return $this->render('user/index_admin.html.twig', [
            'admins' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        //ajout envoi mail
        $user = new User();
        // $user = $form->getData();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //envoi mail
            // $email =(new Email())
            // ->from('dragonfly.projet@gmail.com')
            // ->to($user->getEmail())
            // ->subject('new mail')
            // ->text('Connectez vous ')
            // ->html('<H1>Bonjour</H1><br><p>Vous êtes invité à confirmer votre inscription  à DragonFly et mofifier vos accès</p>
            // <br>Voici vos informations de connexions: Username:  '$user->getUsername, 'Password : ' $user->getPassword.);

            // $mailer->send($email);
            // return new Response("Création réussi! Votre collaborateur à recu son mail de connexion");

            return $this->redirectToRoute('user_index');
        }

        // return $this->render('user/new.html.twig', [
        //     'user' => $user,
        //     'form' => $form->createView(),
        // ]);
        }
    
    /**
     * @Route("/user/my-event", name="user_showEvent")
     */
    public function showEvent(): Response
    {
        // $me = $this->getUser();
        // dd($me);
        return $this->render('user/showEvent.html.twig', [
            // "me"=>$me
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/moncompte.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/inscription-evenement/{id}", name="event_subscribe")
     */
    public function inscriptionEvent($id, EventRepository $eventRepository){
        $event = $eventRepository->find($id);
        $user = $this->getUser();
        $user->addEvent($event);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        //
        return new Response("Et hop!!!!");
    }
   

    /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
