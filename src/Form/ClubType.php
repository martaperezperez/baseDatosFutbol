<?php

namespace App\Form;

use App\Entity\Club;
use PHPUnit\Framework\Constraint\Callback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'constraints'=>[
                    new NotBlank([
                        'message' => 'The name cannot be empty'
                    ]),
                    new Regex([
                        'pattern'=> "/^[A-Z]/",
                        'message'=>'The value must begin with a capital letter'
                    ])

                ],
            ])
            ->add('budget', null, [
                'constraints'=>[
                    new NotBlank([
                        'message' => 'The budget cannot be empty'
                    ]),
                    new Range([
                        'min'=>1000,
                        'max'=>40000,
                        'notInRangeMessage'=>'The budget must be between {{ min }} and {{ max }}'
                    ])
                ],
            ])
            ->add('email', null, [
        'constraints'=>[
            new NotBlank([
                'message' => 'The email cannot be empty'
            ]),
            new Email(['message' => 'The email is not a valid email.']),

        ],
    ])
            ->add('phone', null, [
                'constraints'=>[
                    new NotBlank([
                        'message' => 'The phone cannot be empty'
                    ]),
                    new Length([
                        'min'=>9,
                        'max'=>9,
                        'exactMessage'=>'The phone must be 9 digits'
                    ])
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
