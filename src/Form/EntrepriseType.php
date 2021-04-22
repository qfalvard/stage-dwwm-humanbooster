<?php

namespace App\Form;

use App\Entity\Entreprise;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom de l\'entreprise',
                'attr' => [
                    'placeholder' => 'Comment s\'appelle l\'entreprise ?'
                ]
                ])
            ->add('raisonSocial', TextType::class,[
                'label' => 'Raison Social',
                'attr' => [
                    'placeholder' => 'Pour quoi avez-vous contactez cette entreprise ?'
                ]
                ])
             ->add('activite', TextType::class,[
                'label' => 'Activité de l\'entreprise',
                'attr' => [
                    'placeholder' => ' Quel est le secteur d\'activité de l\'entreprise ?'
                ]
                ])
            ->add('telephone', NumberType::class,[
                'label' => 'Téléphone de l\'entreprise',
                'attr' => [ 'placeholder' => 'Le numéro de téléphone de l\'entreprise.'],
                'constraints' => [ new Length(['max' => 12]), new Length(['min' => 10])]
                 ])

            ->add('email', EmailType::class, [
                'label' => 'L\'email de l\'entreprise',
                'attr' => [
                    'placeholder' => 'Saisir l\'adresse email de l\'entreprise.'
                ]
            ])
            ->add('adresse', AdresseType::class,[ 
            'label' => 'Adresse de l\'entreprise',
            ]);
    }
        
   
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
