<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * Liste des produits
     * @isGranted("ROLE_ADMIN")
     * @Route("/", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * Ajout d'un nouveau produit
     * @isGranted("ROLE_PRODUCER")
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository, StoreRepository $storeRepository, UserRepository $userRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var ?User $user
             */
            $user = $this->getUser();

            // On récupére le store du user connecté pour l'associer au Product à la création de ce dernier
            $product->setStore($user->getStore());

            $storeId = $user->getStore()->getId();

            $productRepository->add($product, true);
            $this->addFlash('success', 'Un produit a été ajouté.');

            if ($user->getRoles() == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->render('product/show.html.twig', [
                    'product' => $product,
                ]);
            }
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * Affichage d'un produit (selon son id)
     * @isGranted("ROLE_PRODUCER")
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * Modification d'un produit (selon son id)
     * @isGranted("ROLE_PRODUCER")
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        /**
         * @var ?User $user
         */
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);

            if ($user->getRoles() == "ROLE_ADMIN") {
                return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
            } else {
                return $this->render('product/show.html.twig', [
                    'product' => $product,
                ]);
            }
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    /**
     * Suppression d'un produit (selon son id)
     * @isGranted("ROLE_PRODUCER")
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        /**
         * @var ?User $user
         */
        $user = $this->getUser();

        if ($user->getRoles() == "ROLE_ADMIN") {
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('main/index.html.twig', [
                'product' => $product,
            ]);
        }
}
}
