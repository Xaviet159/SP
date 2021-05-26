<?php

namespace App\Controller;

use App\Repository\PurchaseRepository;
use Stripe\Stripe;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayementStripeController extends AbstractController
{
    /**
     * @Route("/payement/stripe/{id}", name="payement_stripe")
     */
    public function showCardForm($id, PurchaseRepository $purchaseRepository): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51ImK9sH3zEb4xb70qzfELGVC3yVazOEu7h88YgHMv3s8dAn1G4bdf8thfMYeyx6kF2wflQnV8DySuxhQ7VUWi2w000zrKUTgKW');
        
        $purchase = $purchaseRepository->find($id);

        if(!$purchase){
            return $this->redirectToRoute('projects');
        }

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $purchase->getTotal(),
            'currency' => 'eur'
        ]);

        return $this->render('payement_stripe/index.html.twig', [
            'clientSecret' => $intent->client_secret,
        ]);
    }
}