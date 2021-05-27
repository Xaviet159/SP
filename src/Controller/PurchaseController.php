<?php

namespace App\Controller;

use DateTime;
use App\Entity\Purchase;
use App\Form\PurchaseType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseController extends AbstractController
{
    /**
     * @Route("/purchase/{id}", name="purchase")
     */
    public function index($id, Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $project = $projectRepository->find($id);
        
        $purchase = new Purchase;
        $form = $this->createForm(PurchaseType::class, $purchase);

        $form->handleRequest($request);
        // if(!$form->isSubmitted()){
        //     $this->addFlash('warning', 'Vous devez remplir le formulaire de confirmation');
        //     return $this->redirectToRoute('projects');
        // }
        if($form->isSubmitted()){
            $purchase->setUser($user);
            $purchase->setProject($project);
            $purchase->setPurchaseAt(new DateTime());
            $em->persist($purchase);
            $em->flush();

            return $this->redirectToRoute('payement_stripe_confirm', array(
                'id'=> $purchase->getId()
            ));
        }
        $formView = $form->createView();
        return $this->render('purchase/index.html.twig', [
            'formView' => $formView,
        ]);
    }
}
