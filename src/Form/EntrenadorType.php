<?php

namespace App\Form;

use App\Entity\Entrenador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrenadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni')
            ->add('name')
            ->add('last_name')
            ->add('team')
            ->add('salary')
            ->add('email')
            ->add('phone')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entrenador::class,
        ]);
    }
}
