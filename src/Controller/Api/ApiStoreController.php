<?php

namespace App\Controller\Api;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiStoreController extends AbstractController
{
    /**
     * @Route("/api/stores", name="app_api_store", methods={"GET"})
     */
    public function browse(StoreRepository $storeRepository): JsonResponse
    {

        // La route a l'air de bien renvoyer ce qui est attendu : testé avec Insomnia, à confirmer

        $stores = $storeRepository->findAll();
        // retourne bien la liste de tous les stores

        return $this->json(

            // 1. les données à renvoyer : la transformation en json est automatique
            $stores,

            // 2, code HTTP
            200,

            // 3. pas d'entêtes particulière
            [],

            // 4. le groupe de données attendues
            ["groups" => "store_list"]

        );
    }

    /**
     * @Route("/api/stores/{id}", name="app_api_store_id", methods={"GET"})
     */
    public function getStoreById(StoreRepository $storeRepository, $id): JsonResponse
    {

        $store = $storeRepository->find($id);

        // Si le store n'existe pas
        // On envoie un message au format json, en indiquant le code http
        if ($store === null) {
            return $this->json(

                // 1. les données à renvoyer : la transformation en json est automatique
                "Le producteur recherché n'existe pas",

                // 2. code HTTP : 404
                Response::HTTP_NOT_FOUND,

                // 3. pas d'entêtes particulière
                [],

                // 4. pas de contexte
                []
            );
        }

        // Si le store existe
        // On le retourne au format json, en indiquant le code http et le nom du groupe qui inclut les données à afficher
        return $this->json(

            // 1. les données à renvoyer : la transformation en json est automatique
            $store,

            // 2. code HTTP
            Response::HTTP_OK,

            // 3. pas d'entêtes particulière
            [],

            // 4. le groupe de données attendues
            ["groups" => "store_list"]

        );
    }

    /**
     * @Route("/api/stores/{id}/products", name="app_api_store_id_products", methods={"GET"})
     */
    public function getProductByStoreId(StoreRepository $storeRepository, $id): JsonResponse
    {

        $store = $storeRepository->find($id);

        // Si le store n'existe pas
        // On envoie un message au format json, en indiquant le code http
        if ($store === null) {
            return $this->json(

                "Le producteur recherché n'existe pas",
                Response::HTTP_NOT_FOUND,
                [],
                []
            );
        }

        // Si le store existe
        // On le retourne au format json, en indiquant le code http et le nom du groupe qui inclut les données à afficher
        return $this->json(

            $store,
            Response::HTTP_OK,
            [],
            ["groups" => "product_store_list"]
        );
    }
}
