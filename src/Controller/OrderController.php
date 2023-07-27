<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="app_order_index", methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_order_new", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request, OrderRepository $orderRepository): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order, true);
        

            $this->addFlash('success', 'Une commande a été ajoutée.');
            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_order_show", methods={"GET"})
     * @isGranted("ROLE_PRODUCER")
     */
    public function show(Order $order): Response
    {
        // Déclaration d'une variable $storeUserId et à l'intérieur, on récupère le user_id du Store demandé (par l'URL)
        $storeUserId = $order->getStore()->getUser()->getId();

        // Déclaration d'une variable $userConnectedId et à l'intérieur, on récupère l'id de l'user connecté
        $userConnectedId = $this->getUser()->getId();

        // Ceci est le rôle de l'user connecté
        $userConnectedRole = $this->getUser()->getRoles();

        if ($userConnectedRole['0'] == "ROLE_ADMIN") {

            // Alors on lui affiche la page show peu importe si le user_id du Store concorde ou non
            return $this->render('order/show.html.twig', [
                'order' => $order,
        ]);

        // Si l'id de l'user connecté est différent du user_id du store demandé
        } elseif ($userConnectedId != $storeUserId) {

            // Alors on le redirige à la page d'accueil (pour le moment)
            return $this->redirectToRoute('app_main_index', [], Response::HTTP_FOUND);

            // Sinon, si l'id de l'user connecté concorde avec l'user_id du store
        } else {

            // On affiche le show
            return $this->render('order/show.html.twig', [
                'order' => $order,
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="app_order_edit", methods={"GET", "POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order, true);

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_order_delete", methods={"POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $orderRepository->remove($order, true);
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }
}
