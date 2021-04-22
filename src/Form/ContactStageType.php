<?php

namespace App\Form;


use App\Entity\Utilisateur;

use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ContactStageType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('prenom', TextType::class,[
            'label' => 'Prenom du contact',
            'attr' => [
                'placeholder' => 'ex: Paul'
            ]
            ])
        ->add('nom', TextType::class,[
            'label' => 'Nom du contact',
            'attr' => [
                'placeholder' => 'ex : Lefèvre'
            ]
            ])
            ->add('email', EmailType::class,[
                'label' => 'L\'email du contact',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
