<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', 
        ['last_username' => $lastUsername, 
        'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     /**
     * Modification mot de passe User
     * 
     * @Route("/security/password", name="app_security_password", methods={"GET", "POST"})
     */
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        // on crée un formulaire, non lié à une entité
        $form = $this->createForm(UserType::class);
        // le formulaire traite la requête
        $form->handleRequest($request);

        // si form valide et soumis
        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère le nouveau mot de passe dans le formulaire
            $newPassword = $form->get('password')->getData();
            // on récupère l'utilisateur connecté
            // @see https://symfony.com/doc/5.4/security.html#fetching-the-user-object
            /** @var User $user L'utilisateur connecté */
            $user = $this->getUser();
            // on le hache
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            // on modifie son mot de passe
            $user->setPassword($hashedPassword);

            // on sauvegarde l'utilisateur
            $entityManager->flush($user);

            // on redirige
            return $this->redirectToRoute('home');
        }

        // on affiche le form
        return $this->renderForm('security/login.html.twig', [
            'form' => $form,
        ]);
    }
}
