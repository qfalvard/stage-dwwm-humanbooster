<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Commune;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Length;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ligne1', TextType::class,[
                'label' => 'Ligne 1',
                'attr' => [
                    'placeholder' => 'ex : Campus Région'
                ]
                ])
            ->add('ligne2', TextType::class,[
                'label' => 'Ligne 2',
                'attr' => [
                    'placeholder' => 'ex : 1 place de la mairie'
                ]
                ])
            ->add('ligne3', TextType::class,[
                'label' => 'Ligne 3',
                'attr' => [
                    'placeholder' => 'ex : Bâtiment A'
                ]
                ])
            ->add('cp', NumberType::class,[
                'label' => 'Code Postal',
                'constraints' => [ new Length(['max' => 5])]
                 ])
            ->add('commune', EntityType::class, [
                'label' => 'Commune',
                'class' => Commune::class,
                'choice_label' => 'nom',
                'placeholder' => 'Veuillez choisir une commune'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
