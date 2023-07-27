<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/store")
 */
class StoreController extends AbstractController
{
    /**
     * @Route("/", name="app_store_index", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function index(StoreRepository $storeRepository): Response
    {
        return $this->render('store/index.html.twig', [
            'stores' => $storeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_store_new", methods={"GET", "POST"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function new(Request $request, StoreRepository $storeRepository, UserRepository $userRepository): Response
    {
        $store = new Store();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var ?User $user
             */
            $user = $this->getUser();

            // On récupére le user connecté pour l'associer au Store à la création de ce dernier
            $store->setUser($this->getUser());

            $storeRepository->add($store, true);
            $this->addFlash('success', 'Une boutique a été ajoutée.');

            if ($user->getRoles() == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_store_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->render('store/show.html.twig', [
                    'store' => $store,
                ]);
            }
        }

        return $this->renderForm('store/new.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_store_show", methods={"GET"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function show(Store $store): Response
    {

        // Déclaration d'une variable $storeUserId et à l'intérieur, on récupère le user_id du Store demandé (par l'URL)
        $storeUserId = $store->getUser()->getId();
        // dd($storeUserId);

        // Déclaration d'une variable $userConnectedId et à l'intérieur, on récupère l'ID de l'user connecté
        $userConnectedId = $this->getUser()->getId();
        // dd($userConnectedId);

        // Ceci est le rôle de l'user connecté
        $userConnectedRole = $this->getUser()->getRoles();
        // dd($userConnectedRole);

        if ($userConnectedRole['0'] == "ROLE_ADMIN") {

            // Alors on lui affiche la page show peu importe si le user_id du Store concorde ou non
            return $this->render('store/show.html.twig', [
                'store' => $store,
            ]);

            // Si l'ID de l'user connecté est différent du user_id du store demandé
        } elseif ($userConnectedId != $storeUserId) {

            // Alors on le redirige à la page d'accueil (pour le moment)
            return $this->redirectToRoute('app_main_index', [], Response::HTTP_FOUND);

            // Sinon, si l'ID de l'user connecté concorde avec l'user ID du store
        } else {

            // On affiche le show
            return $this->render('store/show.html.twig', [
                'store' => $store,
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="app_store_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function edit(Request $request, Store $store, StoreRepository $storeRepository): Response
    {
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $storeRepository->add($store, true);

            /**
             * @var ?User $user
             */
            $user = $this->getUser();

            if ($user->getRoles() == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_store_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->render('store/show.html.twig', [
                    'store' => $store,
                ]);
            }
        }

        return $this->renderForm('store/edit.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_store_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Store $store, StoreRepository $storeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $store->getId(), $request->request->get('_token'))) {
            $storeRepository->remove($store, true);
        }

        /**
         * @var ?User $user
         */
        $user = $this->getUser();

        if ($user->getRoles() == "ROLE_ADMIN") {
            return $this->redirectToRoute('app_store_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('main/index.html.twig', [
                'store' => $store,
            ]);
        }
    }

    /**
     * Liste des produits d'une boutique
     * @Route("/{id}/product", name="app_store_product_index", methods={"GET"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function ProductsByStore(Store $store): Response
    {

        // Déclaration d'une variable $storeUserId et à l'intérieur, on récupère le user_id du Store demandé (par l'URL)
        $storeUserId = $store->getUser()->getId();
        // dd($storeUserId);

        // Déclaration d'une variable $userConnectedId et à l'intérieur, on récupère l'ID de l'user connecté
        $userConnectedId = $this->getUser()->getId();
        // dd($userConnectedId);

        // Ceci est le rôle de l'user connecté
        $userConnectedRole = $this->getUser()->getRoles();
        // dd($userConnectedRole);

        if ($userConnectedRole['0'] == "ROLE_ADMIN") {

            // Alors on lui affiche la page product/indexByStore peu importe si le user_id du Store concorde ou non
            return $this->renderForm('product/indexByStore.html.twig', [
                'store' => $store,
            ]);

            // Si l'ID de l'user connecté est différent du user_id du store demandé
        } elseif ($userConnectedId != $storeUserId) {

            // Alors on le redirige à la page d'accueil (pour le moment)
            return $this->redirectToRoute('app_main_index', [], Response::HTTP_FOUND);

            // Sinon, si l'ID de l'user connecté concorde avec l'user ID du store
        } else {

            // On affiche la page product/indexByStore
            return $this->renderForm('product/indexByStore.html.twig', [
                'store' => $store,
            ]);
        }

        return $this->renderForm('product/indexByStore.html.twig', [
            'store' => $store,
        ]);
    }

    /**
     * Liste des commandes d'une boutique
     * @Route("/{id}/order", name="app_store_order_index", methods={"GET"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function OrdersByStore(Store $store): Response
    {

        // Déclaration d'une variable $storeUserId et à l'intérieur, on récupère le user_id du Store demandé (par l'URL)
        $storeUserId = $store->getUser()->getId();

        // Déclaration d'une variable $userConnectedId et à l'intérieur, on récupère l'id de l'user connecté
        $userConnectedId = $this->getUser()->getId();

        // Ceci est le rôle de l'user connecté
        $userConnectedRole = $this->getUser()->getRoles();

        if ($userConnectedRole['0'] == "ROLE_ADMIN") {

            // Alors on lui affiche la page order/indexByStore peu importe si le user_id du Store concorde ou non
            return $this->renderForm('order/indexByStore.html.twig', [
            'store' => $store,
        ]);

            // Si l'id de l'user connecté est différent du user_id du store demandé
        } elseif ($userConnectedId != $storeUserId) {

            // Alors on le redirige à la page d'accueil (pour le moment)
            return $this->redirectToRoute('app_main_index', [], Response::HTTP_FOUND);

            // Sinon, si l'id de l'user connecté concorde avec l'user_id du store
        } else {

            // On affiche la page order/indexByStore
            return $this->renderForm('order/indexByStore.html.twig', [
                'store' => $store,
            ]);
        }

        return $this->renderForm('product/indexByStore.html.twig', [
            'store' => $store,
        ]);
    }
}
