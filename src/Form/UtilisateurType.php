<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //Bouton qui permet l'activation ou la désactivation du compte avec le booléen de isActif dans l'entity Utilisateur
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices' => [
                        'Administrateur' => "ROLE_ADMIN",
                        'Encadrant' => "ROLE_ENCADRANT",
                        'Formateur TRE' => "ROLE_FORMATEUR_TRE",
                        'Formateur' => "ROLE_FORMATEUR",
                        'Stagiaire' => "ROLE_STAGIAIRE",
                    ],
                    'multiple' => true,
                    'label' => 'Rôle(s)',
                    'attr' => ['data-placeholder' => 'Veuillez choisir un ou plusieurs rôles']
                ]
            )
            ->add(
                'isActif',
                ChoiceType::class,
                array(
                    'choices'  => array(
                        'Oui' => 1,
                        'Non' => 0
                    ),
                    'label' => 'Compte actif',
                    'expanded' => true,
                    'multiple' => false
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
