<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserCompteType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
    public function new(Request $request, MailerInterface $mailer, EntrepriseRepository $entrepriseRepository, UserPasswordEncoderInterface $encoder, SessionInterface $session): Response
    {
        
        $user = new User();

        $admin = $this->getUser();
        $entreprise = $admin->getEntreprise();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $user->setEntreprise($entreprise);
            $user->setRoles(['ROLE_USER']);
            $originePassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $originePassword);
            $user->setPassword($encodedPassword);
            $user = $form->getData();
  
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
            // <br>Voici vos informations de connexions: Username:  '$user->getUsername, 'Password : ' $user->getPassword($originePassword).);

            // $mailer->send($email);
            // return new Response("Création réussi! Votre collaborateur à recu son mail de connexion");

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
        
    }
    
    /**
     * @Route("/user/mes-events", name="user_showEvent")
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
     * @Route("/user/mon-compte", name="user_moncompte")
     */
    public function showCompte(): Response
    {
        $user = $this->getUser();
        return $this->render('user/moncompte.html.twig', [
            "user" => $user,
        ]);
    }

    //ANCHOR - Modification du compte utilisateur personnel

    /**
     * @Route("/user/edit", name="user_moncompte_edit", methods={"GET","POST"})
     */
    public function compte(Request $request, UserPasswordEncoderInterface $encoder, SessionInterface $session) : Response
    {
        // Mise en place du formulaire d'après les informations de l'utilisateur connecté
        $user = $this->getUser();
        if(empty($session->get('password')))
        {
            $session->set('password', $user->getPassword());
        }

        $form = $this->createForm(UserType::class, $user);
        // On hydrate le formulaire avec les données de la requete
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            if(is_null($user->getPassword()))
            {
                $user->setPassword($session->get('password'));

            } else {
                $plainPassword = $user->getPassword();
                $encodedPassword = $encoder->encodePassword($user, $plainPassword);
                $user->setPassword($encodedPassword);
            }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash("success", "Vos informations ont bien été mises à jour.");
        }
        return $this->render('user/moncompte_edit.html.twig', [
            "form"=>$form->createView(),
        ]);
    }
    

    /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function showUser(User $user): Response
    {
        return $this->render('user/show.html.twig', [
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
        return $this->redirectToRoute('user_showEvent');
        
    }

    
    // ANCHOR - Modification du user par l'admin (attribution de role etc)
    /**
     * @Route("/user/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function editUser(Request $request, User $user, $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserCompteType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    //  ANCHOR - Suppression du compte user par l'administrateur

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
