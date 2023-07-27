<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * Liste de tous les paiements
     *
     * @Route("/", name="app_payment_index", methods={"GET"})
     */
    public function index(PaymentRepository $paymentRepository): Response
    {
        // L'index.html.twig est à configurer
        return $this->render('payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
        ]);
    }

    // TODO Voir si utile dans le back office, par contre penser à faire une route API pour les paiements
    /**
     * @Route("/new", name="app_payment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PaymentRepository $paymentRepository): Response
    {   //  creation d'un objet
        $payment = new Payment();

        // On crée la variable form avec les propriétés indiquées
        $form = $this->createForm(PaymentType::class, $payment);
        // On envoit les infos à la BDD
        $form->handleRequest($request);

        // Si le formulaire est soumis et que les infos renseignées sont valides, on ajoute le paiement à la table
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $paymentRepository->add($payment, true);

            // et on redirige sur la liste (index)
            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }
        // On transmet les infos au twig pour l'affichage
        return $this->renderForm('payment/new.html.twig', [
            'payments' => $payment,
            'form' => $form,
        ]);
    }

       /**
     * @Route("/{id}", name="app_payment_show", methods={"GET"})
     */
    public function show(Payment $payment): Response
    {
        return $this->render('payment/show.html.twig', [
            'payments' => $payment,
        ]);
    }

     /**
     * @Route("/{id}/edit", name="app_payment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Payment $payment,PaymentRepository $paymentRepository): Response
    {
        $form = $this->createForm(PaymentType::class, $payment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paymentRepository->add($payment, true);

            return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payment/edit.html.twig', [
            'payments' => $payment,
            'form' => $form,
        ]);
    }

   
    /**
     * @Route("/{id}", name="app_payment_delete", methods={"POST"})
     */
    public function delete(Request $request, Payment $payment, PaymentRepository $paymentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$payment->getId(), $request->request->get('_token'))) {
            $paymentRepository->remove($payment, true);
        }

        return $this->redirectToRoute('app_payment_index', [], Response::HTTP_SEE_OTHER);
    }

}

