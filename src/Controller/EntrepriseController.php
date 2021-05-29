<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Symfony\Component\Mime\Email;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;

class EntrepriseController extends AbstractController
{
    /**
     * @Route("/entreprise", name="entreprise_index", methods={"GET"})
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entreprise_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, MailerInterface $mailer): Response
    {
        $entreprise = new Entreprise();
        $notification= "Votre inscription est validée";
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //
            $user = $form->get("admin")->getData();
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $user->setEntreprise($entreprise);
            // $user->setEntreprise($this->getUser()->getEntreprise())
            // !!!!!!!!! PASSWORD ENCODING
            $originePassword = $user->getPassword();
            $encodedPassword = $encoder->encodePassword($user, $originePassword);
            $user->setPassword($encodedPassword);
            // $user->setEmail();
            //envoi mail
            $email =(new Email())
            ->from('dragonfly.projet@gmail.com')
            ->to($user->getEmail())
            ->subject('Inscription')
            ->text('Inscription ')
            ->html('<H1>Bonjour </H1><br><p>L\'inscription de votre entreprise est enregistrée!</p>');

            $mailer->send($email);
            return new Response($notification);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entreprise);
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('app_login');
        }
        return $this->render('entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/entreprise/{id}", name="entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/entreprise/{id}/edit", name="entreprise_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entreprise $entreprise): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entreprise_index');
        }

        return $this->render('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/entreprise/{id}", name="entreprise_delete", methods={"POST"})
     */
    public function delete(Request $request, Entreprise $entreprise): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprise_index');
    }
}
