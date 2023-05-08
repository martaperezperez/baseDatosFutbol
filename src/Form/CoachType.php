<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', null, [
                'constraints'=> [
                    new NotBlank(),
                ],
            ])
            ->add('name', null, [
                'constraints'=> [
                    new NotBlank(),
                ],
            ])
            ->add('last_name', null, [
                'constraints'=> [
                    new NotBlank(),
                ],
            ])
            ->add('team', null, [
                'constraints'=> [
                    new NotBlank(),
                ],
            ])
            ->add('salary', null, [
                'constraints'=> [
                    new NotBlank(),
                ],
            ])
            ->add('email', null, [
                'constraints'=> [
                    new NotBlank(),
                ],
            ])
            ->add('phone', null, [
                'constraints'=> [
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
            'data_class' => Coach::class,
        ]);
    }
}
