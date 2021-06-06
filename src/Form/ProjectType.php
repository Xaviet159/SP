<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
                'label' => 'Quel serait l\'objectif monétaire à atteindre' ,
                'attr' => ['class' =>'form-control',
                'placholder' => 'Tapez un chiffre rond en €'] 
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
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
