<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Form\UserType as FormUserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * Liste de tous les utilisateurs
     * @Route("/", name="app_user_index", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function index(UserRepository $userRepository): Response
    {
        $allUsers = $userRepository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $allUsers,

        ]);
    }

    /**
     * Création d'un nouvel utilisateur (il ne faut pas être connecté)
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(FormUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // avant de sauvegarder l'utilisateur
            // on récupère le mot de passe en clair
            $plainTextPassword = $user->getPassword();
            // on hash son mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
            // et on lui redonne (on l'écrase)
            $user->setPassword($hashedPassword);

            $user->setRoles(["ROLE_PRODUCER"]);

            $userRepository->add($user, true);
            $this->addFlash('success', 'Le compte a été créé avec succès !');

            if ($user->getRoles() == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('user/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Profil d'un utilisateur
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function show(User $user): Response
    {

        // Déclaration d'une variable $userId et à l'intérieur, on récupère l'ID du user demandé (par l'URL)
        $userId = $user->getId();
        // dd($userId);

        // Déclaration d'une variable $userConnectedId et à l'intérieur, on récupère l'ID de l'user connecté
        $userConnectedId = $this->getUser()->getId();
        // dd($userConnectedId);

        // Ceci est le rôle de l'user consulté par le show
        // Dans notre cas, nous n'en avons pas besoin, c'était pour mieux comprendre
        // $userRole = $user->getRoles();
        // dd($userRole);

        // Ceci est le rôle de l'user connecté
        $userConnectedRole = $this->getUser()->getRoles();
        // dd($userConnectedRole);

        // Si l'user connecté a le rôle "ROLE_ADMIN"
        // J'ai bloqué ici pendant un moment : le dd($userConnectedRole); renvoie un tableau avec une entrée "0" => "ROLE_ADMIN"
        // Dans la condition il faut donc sélectionner cette entrée, pour faire fonctionner la condition
        if ($userConnectedRole['0'] == "ROLE_ADMIN") {

            // Alors on lui affiche la page show peu importe que l'ID dans l'URL soit différent du sien ou non
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);

        // Si l'ID de l'user demandé est différent que l'ID de l'user connecté alors
        } elseif ($userId != $userConnectedId) {

            // Alors ...
            // Le return est à approfondir, pour le moment on redirige simplement l'utilisateur sur la page "app_main_index" sans indications
            // Lorsque par exemple l'user avec ID 91 est connecté, et qu'il souhaite accéder à http://localhost:8000/user/90
            // L'utilisateur n'a pas accès à la page et est redirigé

            return $this->redirectToRoute('app_main_index', [], Response::HTTP_FOUND);

        } else {

            // Sinon on affiche le show
            
            return $this->render('user/show.html.twig', [
                'user' => $user,
            ]);
        }

    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // TODO à supprimer car on ne rehash pas le mot de passe
            // // avant de sauvegarder l'utilisateur
            // // on récupère le mot de passe en clair
            // $plainTextPassword = $user->getPassword();
            // // on hash son mot de passe
            // $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
            // // et on lui redonne (on l'écrase)
            // $user->setPassword($hashedPassword);

            $userRepository->add($user, true);

            if ($user->getRoles() == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->render('user/show.html.twig', [
                    'user' => $user,
                ]);
            }
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        if ($user->getRoles() == "ROLE_ADMIN") {
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('main/index.html.twig', [
                'user' => $user,
            ]);
        }
    }

}
