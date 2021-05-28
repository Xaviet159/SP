<?php

namespace App\Controller\Stripe;

use Stripe\Stripe;
use App\Entity\Purchase;
use Stripe\PaymentIntent;
use Symfony\Component\HttpFoundation\Response;



class StripeService 
{
    protected $secretKey;
    protected $publicKey;

    public function __construct(string $secretKey, string $publicKey)
    {
        $this->secretKey = $secretKey;
        $this->publicKey = $publicKey;
    }

    public function getPaymentintent(Purchase $purchase) 
    {
        \Stripe\Stripe::setApiKey($this->secretKey);

        return \Stripe\PaymentIntent::create([
            'amount' => $purchase->getTotal()*100,
            'currency' => 'eur'
        ]); 
    }
}
