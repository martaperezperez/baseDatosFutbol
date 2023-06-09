<?php

namespace App\Form;

use App\Entity\Player;
use App\Validator\Salary;
use App\Validator\SalaryValidator;
use PharIo\Manifest\Email;
use PhpParser\Node\Expr\BinaryOp\Equal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use function PHPUnit\Framework\isNull;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The dni cannot be empty'
                    ]),
                    new Regex([
                        'pattern'=>"/^\d{8}/",
                        'message'=>'The dni must start with 8 numbers'
                    ]),
                    new Regex([
                        'pattern'=>"/[A-Z]$/",
                        'message'=>'The dni must end in a capital letter'
                    ]),
                    new Length([
                        'min'=>9,
                        'max'=>9,
                        'exactMessage'=>'The dni cannot have more than 9 digits'
                    ])
                    ],
                ])
            ->add('name', null, [
                'constraints' => [
                new NotBlank([
                    'message' => 'The name cannot be empty'
                ]),
                    new Regex([
                        'pattern'=>"/^[A-Z]/",
                        'message'=>'The values must begin with a capital letter'
                    ])
                ],
                ])
            ->add('last_name', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The last name cannot be empty'
                    ]),
                    new Regex([
                        'pattern'=>"/^[A-Z]/",
                        'message'=>'The values must begin with a capital letter'
                    ])
                    ],
                ])
            ->add('team', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The team cannot be empty']),

                    new Regex([
                        'pattern'=>"/^[A-Z]/",
                        'message'=>'The values must begin with a capital letter'
                    ])
                    ],

                ])
            ->add('salary', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The salary cannot be empty'
                    ]),
                    new Range([
                        'min'=>1000,
                        'max'=>40000,
                        'notInRangeMessage'=>'The salary must be between {{ min }} and {{ max }}'
                    ]),
                    new Salary(),

                    ],

                ])
            ->add('position', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The position cannot be empty'
                    ]),
                    new Choice([
                        'choices'=>["Portero", "Defensa central", "Defensa Lateral", "Mediocentro", "Mediapunta", "Mediocentro defensivo", "Interior derecho", "Interior izquierdso", "Delanter"],
                        'message'=>'This position does not exist choose between {{ choices }}'
                    ])
                    ],
                ])
            ->add('dorsal', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The dorsal cannot be empty'
                    ]),
                    new Range([
                        'min'=>1,
                        'max'=>99,

                    ])
                    ],
                ])
            ->add('email', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The email cannot be empty'
                    ]),
                    new \Symfony\Component\Validator\Constraints\Email(['message'=>'The email is not a valid email.']),
                    ],
                ])
            ->add('phone', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'The phone cannot be empty'
                    ]),
                    new Length([
                        'min'=>9,
                        'max'=>9,
                        'exactMessage'=>'The phone must be 9 digits'
                    ])
                    ]
            ])
        ;
    }
    public function getBlockPrefix(): string
    {
     return '';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
