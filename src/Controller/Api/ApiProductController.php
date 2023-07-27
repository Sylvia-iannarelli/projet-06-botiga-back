<?php

namespace App\Controller\Api;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiProductController extends AbstractController
{
    /**
     * @Route("/api/products", name="app_api_product", methods={"GET"})
     */
    public function browse(ProductRepository $productRepository): JsonResponse
    {

        // On récupere un tableau d'entités symfony
        $products = $productRepository->findAll();

        // On le retourne au format json, en indiquant le code http et le nom du groupe qui inclut les données à afficher
        return $this->json(

            $products,
            Response::HTTP_OK,
            [],
            ["groups" => "product_list"]

        );
    }

    /**
     * @Route("/api/products/{id}", name="app_api_product_id", methods={"GET"})
     */
    public function getProductById(ProductRepository $productRepository, $id): JsonResponse
    {

        $product = $productRepository->find($id);

        // Si le produit n'existe pas
        // On envoie un message au format json, en indiquant le code http
        if ($product === null) {
            return $this->json(

                "Le produit recherché n'existe pas",
                Response::HTTP_NOT_FOUND,
                [],
                []
            );
        }

        // Si le produit existe
        // On le retourne au format json, en indiquant le code http et le nom du groupe qui inclut les données à afficher
        return $this->json(

            $product,
            Response::HTTP_OK,
            [],
            ["groups" => "product_list"]
        );
    }
}
