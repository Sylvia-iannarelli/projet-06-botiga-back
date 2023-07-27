<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use phpDocumentor\Reflection\Types\Null_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * 
 */
class ApiCategoryController extends AbstractController
{
    /**
    * @Route("/api/categories", name="app_api_category", methods={"GET"})
    */
    public function browse(CategoryRepository $categoryRepository): JsonResponse
    {
        //route GET category : https://api/categories
        //test avec thunderClient =>http://localhost:8000/api/categories
        $category = $categoryRepository->findAll();

        return $this->json($category, 200, [], ["groups" => "category_list"]);
    }

    /**
     * @Route("/api/categories/{id}", name="app_api_category_id", methods={"GET"})
     */
    public function getCategoryById(CategoryRepository $categoryRepository, $id): JsonResponse
    {

        $category = $categoryRepository->find($id);

        // Si la categorie n'existe pas
        // On envoie un message au format json, en indiquant le code http
        if ($category === null) {
            return $this->json(

                "La catégorie recherchée n'existe pas",
                Response::HTTP_NOT_FOUND,
                [],
                []
            );
        }

        // Si la catégorie existe
        // On la retourne au format json, en indiquant le code http et le nom du groupe qui inclut les données à afficher
        return $this->json(

            $category,
            Response::HTTP_OK,
            [],
            ["groups" => "category_list"]
        );
    }

    /**
     * @Route("/api/categories/{id}/products", name="app_api_category_id_products", methods={"GET"})
     */
    public function getProductByCategoryId(CategoryRepository $categoryRepository, $id): JsonResponse
    {

        $category = $categoryRepository->find($id);

        // Si la catégorie n'existe pas
        // On envoie un message au format json, en indiquant le code http
        if ($category === null) {
            return $this->json(

                "La catégorie recherchée n'existe pas",
                Response::HTTP_NOT_FOUND,
                [],
                []
            );
        }

        // Si la catégorie existe
        // On la retourne au format json, en indiquant le code http et le nom du groupe qui inclut les données à afficher
        return $this->json(

            $category,
            Response::HTTP_OK,
            [],
            ["groups" => "product_category_list"]
        );
    }

    // TODO voir avec Karine si suite à donner ci-dessous ?

    //TODO a faire
        //GET category/store : https://api/zipCode=?/categories/id/stores/
        // ou https://api/categories/id/stores ?

    //   /**
    //  * endpoint for producers of a specific category
    //  *
    //  * @Route("/api/categories/id/producers", name="app_api_categories_getProducersByCategories", methods={"GET"})
    //  */

    //  public function getProducersByCategories(Category $category = null): JsonResponse
    //  {
    //      if($category) {
    //          return $this->json(["error" => "la category est "], Response::HTTP_NOT_FOUND);
    //      }
    //  }
}