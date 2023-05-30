<?php

namespace App\Form;

use App\Entity\Coach;
use App\Validator\CoachSalary;
use App\Validator\Salary;
use PharIo\Manifest\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;


class CoachType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dni', null, [
                'constraints'=> [
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
                'constraints'=> [
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
                'constraints'=> [
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
                'constraints'=> [
                    new NotBlank([
                        'message' => 'The team cannot be empty'
                    ]),
                    new Regex([
                        'pattern'=>"/^[A-Z]/",
                        'message'=>'The values must begin with a capital letter'
                    ])
                ],
            ])
            ->add('salary', null, [
                'constraints'=> [
                    new NotBlank([
                        'message' => 'The salary cannot be empty'
                    ]),
                    new Range([
                        'min'=>1000,
                        'max'=>40000,
                        'notInRangeMessage'=>'The salary must be between {{ min }} and {{ max }}'
                    ]),
                    new CoachSalary()

                ],
            ])
            ->add('email', null, [
                'constraints'=> [
                    new NotBlank([
                        'message' => 'The email cannot be empty'
                    ]),
                    new \Symfony\Component\Validator\Constraints\Email(['message'=>'The email is not a valid email.']),

                ],
            ])
            ->add('phone', null, [
                'constraints'=> [
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

    public function getBlockPrefix():string
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
