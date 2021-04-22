<?php

namespace App\Form;

use App\Entity\RechercheStage;
use App\Entity\Entreprise;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Form\EntrepriseType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class RechercheStageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('detail', TextType::class,[
                'label' => 'Détail',
                'attr' => [
                    'placeholder' => 'Ce que vous avez fait pour cette recherche de stage'
                ]
                ])
            ->add('date', DateType::class, [
                'format' => 'dd/MM/yyyy',
                'years' => range(2000, 2050)
            ])

            ->add('entreprise', EntityType::class, [
                'class' => Entreprise::class,
                'choice_label' => 'nom',
                'placeholder' => 'Veuillez choisir une enterprise'
            ])
            ->add('proContact', EntityType::class, [
                'class' => Utilisateur::class,
                'label' => 'Contact',
                'choice_label' => function ($proContact) {
                    return $proContact->getNom() . ' ' . $proContact->getPrenom();
                },
                'placeholder' => 'Veuillez choisir un contact'
            ])
            ->add('reponse', ChoiceType::class,[
                'choices' => [
                    'Avez-vous eu une réponse ? '=> "",
                    'Non' => "0",
                    'Oui' => "1",
                ],
                'multiple' => false,
                'label' => 'Réponse de l\'entreprise'
            ]);
            
    }
        
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RechercheStage::class,
        ]);
    }
}
