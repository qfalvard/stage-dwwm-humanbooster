<?php

namespace App\Form;


use App\Entity\Utilisateur;

use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('prenom')
            ->add('nom')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    // 'Administrateur' => "ROLE_ADMIN",
                    'Encadrant' => "ROLE_ENCADRANT",
                    'Formateur TRE' => "ROLE_FORMATEUR_TRE",
                    'Formateur' => "ROLE_FORMATEUR",
                    'Stagiaire' => "ROLE_STAGIAIRE",
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Choisissez au moins un rôle pour cette utilisateur',
                    ])
                ],
                'multiple' => true,
                'label' => 'Rôle(s)',
                'attr' => ['data-placeholder' => 'Veuillez choisir un ou plusieurs rôles']
            ])


            // ->add('plainPassword', PasswordType::class, [
            //     // instead of being set onto the object directly,
            //     // this is read and encoded in the controller
            //     'mapped' => false,
            // 'constraints' => [
            //     new NotBlank([
            //         'message' => 'Please enter a password',
            //     ]),
            //     new Length([
            //         'min' => 6,
            //         'minMessage' => 'Your password should be at least {{ limit }} characters',
            //         // max length allowed by Symfony for security reasons
            //         'max' => 4096,
            //     ]),
            // ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
