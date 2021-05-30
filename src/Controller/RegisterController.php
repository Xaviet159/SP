<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User;
        
        $form = $this->createForm(RegisterType::class, $user);

            $form->handleRequest($request);
            
            if($form->isSubmitted()){  
                $encoded = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($encoded);

                $em->persist($user);
                $em->flush();

                return new RedirectResponse('/login');
            }

            $formView = $form->createView();

        return $this->render('register/index.html.twig', [
            'formView' => $formView,
        ]);
    }
}
