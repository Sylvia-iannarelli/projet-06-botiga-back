<?php

namespace App\Controller\Api;

use App\Repository\OrderRepository;
use App\Entity\Order;
use App\Entity\Orderline;
use App\Repository\OrderlineRepository;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ApiOrderController extends AbstractController
{

    /**
     * Liste des commandes de l'utilisateur connecté
     * @isGranted("ROLE_USER")
     * @Route("api/orders", name="browse", methods={"GET"})
     */
    public function browse(OrderRepository $orderRepository): JsonResponse
    {
        // On déclare une variable $user pour pouvoir récupérer l'ID de l'user connecté
        $user = $this->getUser();
        // on cherche toutes les commandes qui concernent l'utilisateur connecté
        $orders = $orderRepository->findBy(['user' => $user]);

        if ($user == null) {
            return $this->json(
                // 1. un message d'erreur
                "Vous devez être connecté-e",
                //2. code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }

        return $this->json(

            // 1. les données à renvoyer : la transformation en json est automatique
            $orders,
            // 2. code HTTP
            Response::HTTP_OK,
            // 3. pas d'entête particulière
            [],
            // 4. le groupe de données attendues
            ["groups" => "order_list"]
            
        ); 
    }

    // TODO PROTECTION A AJOUTER
    // ! route qui renvoie une commande 
    /**
     * renvoie une commande  spécifique
     * @isGranted("ROLE_USER")
     * @Route("/api/orders/{id}", name="read", requirements={"id"="\d+"}, methods={"GET"})
     * @return JsonResponse
     */
    public function read($id, OrderRepository  $orderRepository): JsonResponse
    {

        $order =  $orderRepository->find($id);
        $orderUserId = $order->getUser()->getId();
        $userConnectedId = $this->getUser()->getId();

        // TODO 
        // on vérifie ici que l'id du user connecté est égal à l'id du user de la commande
        if ($userConnectedId != $orderUserId) {
            return $this->json(
                // 1. un message d'erreur
                "Vous devez être connecté-e",
                //2. code HTTP : 404 NOT_FOUND
                Response::HTTP_NOT_FOUND,
            );
        }

        return $this->json(
            // 1. les données à renvoyer : la transformation en json est automatique
            $order,
            // 2. code HTTP
            200,
            // 3. pas d'entêtes particulière
            [],
            // 4. le contexte
            // dans le contexte on précise le nom du/des groupes de serialisation
            ["groups" => "order_show"]
        );
    }

    // ! route qui ajoute une commande 
    /**
     * @isGranted("ROLE_USER")
     * @Route("/api/orders/new", name="api_orders_add", methods={"POST"})
     */
    public function add(
        OrderRepository $orderRepository,
        Request $request,
        ProductRepository $productRepository,
        OrderlineRepository $orderlineRepository,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse {
        $user = $this->getUser();

        $jsonContent = $request->getContent();
        // dd($jsonContent);

        // si on ne reçoit aucun JSON
        if ($jsonContent === "") {
            return $this->json("Le contenu de la requete est invalide", Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        // dd($data);

        foreach ($data as $orderData) {
            // dd($orderData);

            $order = new Order;
            $order->setUser($user);
            $orderRepository->add($order, true);

            $amount = 0;
            $totalQuantity = 0;

            $order = $orderRepository->findBy(array(), array('id' => 'desc'), 1, 0)[0];
            
            foreach ($orderData["products"] as $productData) {
                $product = $productRepository->find($productData["productId"]);
                $store = $product->getStore();
                $orderline = new Orderline;
                $orderline->setProduct($product);
                $orderline->setQuantity($productData["quantity"]);
                $orderline->setOrderCode($order);

                $errors = $validatorInterface->validate($orderline);
                if (count($errors) > 0) {
                    return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                $orderlineRepository->add($orderline, true);
                $amount += $product->getPrice() * $productData["quantity"];
                $totalQuantity += $productData["quantity"];
            }

            // dd($order);
            $order->setOrderPrice($amount);
            $order->setQuantity($totalQuantity);
            $order->setStore($store);
            $orderRepository->add($order, true);
        }

        return $this->json($order, 200, [], ["groups" => ["order_list", "order_show"]]);
    }

}
