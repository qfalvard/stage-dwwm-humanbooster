<?php

namespace App\Form;

use App\Entity\TitreProfessionnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TitreProfessionnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sigle')
            ->add('nom')
            ->add('dateApplication', DateType::class, [
                // 'data'   => new \DateTime('2020-01-01'),
                // 'attr'   => ['min' => (new \DateTime())->format('Y-m-d H:i:s')],
                'format' => 'dd/MM/yyyy',
                'years' => range(2000, 2050)
            ])
            ->add('isActif', HiddenType::class);
    }
        

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TitreProfessionnel::class,
        ]);
    }
}
