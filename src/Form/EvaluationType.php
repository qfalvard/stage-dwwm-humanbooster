<?php

namespace App\Form;

use App\DataFixtures\Module;
use App\Entity\Evaluation;
use App\Entity\Module as EntityModule;
use App\Entity\Objectif;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        
        ->add('Module', EntityType::class, [
            'class' => EntityModule::class,
            'choice_label' => 'nom',
        ])
        ->add('Objectif', EntityType::class, [
            'class' => Objectif::class,
            'choice_label' => 'nom',
        ])
            
        ->add('date', DateType::class, [
                'format' => 'dd/MM/yyyy'
            ])

        ->add('niveauAcquisition', ChoiceType::class, [
                'choices' => [
                'Acquis' => "15",
                'En Cours d\'Acquisition' => "10",
                'Non Acquis' => "5",
                ],
                'multiple' => false,
                'label' => 'Niveau Acquisition'
            ])
            ->add('Utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom',
            
            ])

            
        ->add('commentaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
