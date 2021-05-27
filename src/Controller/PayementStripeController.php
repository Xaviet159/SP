<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Purchase;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PayementStripeController extends AbstractController
{
    /**
     * @Route("/payement/stripe/{id}/confirm", name="payement_stripe_confirm")
     */
    public function payementConfirm($id, ProjectRepository $projectRepository, PurchaseRepository $purchaseRepository, EntityManagerInterface $em): Response
    {
        \Stripe\Stripe::setApiKey('sk_test_51ImK9sH3zEb4xb70qzfELGVC3yVazOEu7h88YgHMv3s8dAn1G4bdf8thfMYeyx6kF2wflQnV8DySuxhQ7VUWi2w000zrKUTgKW');
        
        $purchase = $purchaseRepository->find($id);

        if(!$purchase){
            return $this->redirectToRoute('projects');
        }else{
           $intent = \Stripe\PaymentIntent::create([
            'amount' => $purchase->getTotal()*100,
            'currency' => 'eur'
        ]); 
        }

        return $this->render('payement_stripe/index.html.twig', [
            'clientSecret' => $intent->client_secret,
            'id' => $id
        ]);
    }

    /**
     * @Route("/payement/stripe/{id}/succes", name="payement_stripe_succes")
     */
   public function paymentSucces($id, PurchaseRepository $purchaseRepository, ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $purchase = $purchaseRepository->find($id);

        $user = $this->getUser($purchase->getUser());
        $project = $projectRepository->find($purchase->getProject());
        

        if(!$purchase || ($purchase && $purchase->getUser() !== $this->getuser()) || ($purchase && $purchase->getStatus() === Purchase::STATUS_PAID)){
           $this->addFlash('warning', "La commande n'existe pas");
           return $this->redirectToRoute("purchase", array(
            'id'=> $project->getId()
            ));
        }else{
            $purchase->setStatus('PAID');
            $em->persist($purchase);
            $em->flush();
        }

        if($purchase->getStatus() == 'PAID'){
            $project->setContributor($project->getContributor() + 1);
            $project->setTargetCounter($project->getTargetCounter() + $purchase->getTotal());

            $em->persist($project);
            $em->flush();
            dump($user, $project);

            return $this->render('payement_stripe/succes.html.twig', [
                'user' => $user,
                'project' => $project
            ]);
        }

    }
}
