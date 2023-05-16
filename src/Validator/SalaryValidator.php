<?php

namespace App\Validator;

use App\Entity\Club;

use App\Entity\Player;
use http\Exception;
use http\Message;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SalaryValidator extends ConstraintValidator
{
    /**
     * @throws \Exception
     */
    public function validatePlayerSalary(Player $player)
    {

        $club=$player->getClub();
        /* @var App\Validator\Salary $constraint */

        $salary = $player->getSalary();
         $clubBudget = $club->getBudget();


        if (($clubBudget - $salary) < 0 ) {

           throw new \Exception('Player salary exceeds club budget or gives zero or less');

           // return new JsonResponse(['message'=>'Player salary exceeds club budget'], Response::HTTP_CREATED);
        }


    }



    public function validate(mixed $value, Constraint $constraint)
    {
        /* @var App\Validator\Salary $constraint */

        $player=$this->context->getRoot()->getData();
        $this->validatePlayerSalary($player);

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ salary }}', $value)
            ->addViolation();

        // TODO: Implement validate() method.


    }



}
