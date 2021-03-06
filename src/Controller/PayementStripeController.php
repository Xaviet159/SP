<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Purchase;
use Symfony\Component\Mime\Address;
use App\Repository\ProjectRepository;
use App\Repository\PurchaseRepository;
use App\Controller\Stripe\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class PayementStripeController extends AbstractController
{
    /**
     * @Route("/payement/stripe/{id}/confirm", name="payement_stripe_confirm")
     */
    public function payementConfirm($id, PurchaseRepository $purchaseRepository, StripeService $stripeService)
    {    
        $purchase = $purchaseRepository->find($id);

        if(!$purchase || ($purchase && $purchase->getUser() !== $this->getuser())){
            return $this->redirectToRoute('projects');
        }else{
            $intent = $stripeService->getPaymentIntent($purchase);
        }

        return $this->render('payement_stripe/index.html.twig', [
            'clientSecret' => $intent->client_secret,
            'id' => $id,
            'stripePublicKey' => $stripeService->getPublicKey()
        ]);
    }

    /**
     * @Route("/payement/stripe/{id}/succes", name="payement_stripe_succes")
     */
   public function paymentSucces($id, PurchaseRepository $purchaseRepository, ProjectRepository $projectRepository, EntityManagerInterface $em, MailerInterface $mailer)
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
            $purchase->setStatus("PAID");
            $em->persist($purchase);
            $em->flush();
        }

        if($purchase->getStatus() == "PAID")
        {
            $project->setContributor($project->getContributor() + 1);
            $project->setTargetCounter($project->getTargetCounter() + $purchase->getTotal());

            $em->persist($project);
            $em->flush();

            $email = new TemplatedEmail();
            $email->to(new Address($user->getEmail(), $user->getFullName()))
                ->from("contact@mail.com")
                ->subject("Bravo, votre contribution a bien ??t?? confirm??e")
                ->htmlTemplate("emails/purchase_success.html.twig")
                ->context([
                    "purchase" => $purchase,
                    "project" => $project,
                    "user" => $user
                ]);
                $mailer->send($email);

            return $this->render("payement_stripe/succes.html.twig", [
                "user" => $user,
                "project" => $project
            ]);
        }

    }
}
