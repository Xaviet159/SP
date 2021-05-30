<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        
        $form = $this->createForm(ContactType::class);

            $form->handleRequest($request);
            
            if($form->isSubmitted()){  
               $email = (new TemplatedEmail())
                        ->from('contact@socialplanet.be')
                        ->to('admin@socialplanet.be')
                        ->subject('Un utilisateur de Social-Planet vous a contacté')
                        ->htmlTemplate('emails/contact.html.twig')
                        ->context([
                            'data' =>$form->getData()
                        ]);
                        $mailer->send($email);

                return new RedirectResponse('/');
            }

            $formView = $form->createView();

        return $this->render('contact/index.html.twig', [
            'formView' => $formView,
        ]);
    }
}
