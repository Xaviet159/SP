<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="project")
     */
    public function index(): Response
    {
        return $this->render('project/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/project/create", name="project_create")
     */
    public function create(FormFactoryInterface $factory)
    {
        $builder = $factory->createBuilder();

        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel est le nom de votre projet ?',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description courte',
                'attr' => ['class' =>'form-control',
                'placholder' => 'Tapez une description assez courte mais parlante pour le visiteur']
            ])
            ->add('objectiveAmount', MoneyType::class, [
                'label' => 'Quel serait l\'objectif monetaire à atteindre' ,
                'attr' => ['class' =>'form-control',
                'placholder' => 'Tapez un chiffre rond en €'] 
            ])
            ->add('startAt', DateType::class, [
                'label' => 'A quelle date voulez-vous lancer le crowfunding ? (Comptez entre 1 à 3 semaines pour la validation de celui-ci)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('endAt', DateType::class, [
                'label' => 'A quelle date voulez-vous terminer le crowfunding ?',
                'attr' => ['class' => 'form-control']
            ])
            ->add('projectSuportedBy', ChoiceType::class, [
                'label' => 'Votre projet est porté par',
                'attr' => ['class' => 'form-control'],
                'placeholder' => '-- Choisir catégorie --',
                'choices' => [
                    'Moi-même' => 1,
                    'Mon association' => 2,
                    'Mon entreprise' => 3
                ]            
            ])
            ->add('urlSocial', TextType::class, [
                'label' => 'Url social (facebook)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('urlImage', TextType::class, [
                'label' => 'Insérez une URL pour l\'image',
                'attr' => ['class' => 'form-control']
            ])
            ->add('phoneNumber', NumberType::class, [
                'label' => 'Inserez un numéro de contact',
                'attr' => ['class' => 'form-control']
            ]);
            
            $form = $builder->getForm();
            $formView = $form->createView();

        return $this->render('project/create.html.twig', [
            'formView' => $formView
        ]);
    }
}
