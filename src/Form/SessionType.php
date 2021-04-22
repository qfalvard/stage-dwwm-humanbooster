<?php

namespace App\Form;

use App\Entity\Adresse;
use App\Entity\Former;
use App\Entity\Session;
use App\Entity\TitreProfessionnel;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type as Form;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
            'intitule', TextType::class, ['label' => 'Intitulés', 'attr' => ['placeholder' => 'Veuillez saisir l\'intitulé de la session']])
            ->add('dateDebut', DateType::class, [
                // 'data'   => new \DateTime('2020-01-01'),
                'format' => 'dd/MM/yyyy'
            ])
            ->add('dateFin', DateType::class, [
                // 'data'   => new \DateTime(),
                'format' => 'dd/MM/yyyy'
            ])
            ->add('debutStage', DateType::class, [
                // 'data'   => new \DateTime(),
                'format' => 'dd/MM/yyyy'
            ])
            ->add('finStage', DateType::class, [
                // 'data'   => new \DateTime(),
                'format' => 'dd/MM/yyyy'
            ])
            ->add('Moodle', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Http://']])
            ->add('titreProfessionnel', EntityType::class, [
                'class' => TitreProfessionnel::class,
                'choice_label' => function (TitreProfessionnel $titreProfessionnel) {
                    return $titreProfessionnel->getNom() . ' (' . $titreProfessionnel->getDateApplication()->format("d/m/Y") . ')';
                },
                'placeholder' => 'Veuillez choisir un titre professionnel'
            ])
            ->add('adresse', EntityType::class, [
                'label' => 'Adresse ou lieu',
                'class' => Adresse::class,
                'choice_label' => function (Adresse $adresse) {
                    return $adresse->getLigne1() . ' (' . $adresse->getCP() . ' ' . strtoupper($adresse->getCommune()->getNom()) . ')';
                },
                'placeholder' => 'Veuillez choisir une adresse ou un lieu'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
