<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints'=>[
                    new NotBlank(),
                ],
            ])
            ->add('budget', null, [
                'constraints'=>[
                    new NotBlank(),
                ],
            ])
            ->add('email', null, [
        'constraints'=>[
            new NotBlank(),
        ],
    ])
            ->add('phone', null, [
                'constraints'=>[
                    new NotBlank(),
                ],
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
