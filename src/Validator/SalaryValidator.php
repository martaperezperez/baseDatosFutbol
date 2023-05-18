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
use function PHPUnit\Framework\isNull;

class SalaryValidator extends ConstraintValidator
{
    /**
     * @throws \Exception
     */
    public function  validatePlayerSalary(Player $player):bool
    {
        $club=$player->getClub();
        if($club!==null) {
            /* @var App\Validator\Salary $constraint */

            $salary = $player->getSalary();
            $clubBudget = $club->getBudget();
            return !(($clubBudget - $salary) <= 0);
        }
            return true;
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        /* @var App\Validator\Salary $constraint */

        $player=$this->context->getRoot()->getData();
            if(!$this->validatePlayerSalary($player)){
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ salary }}', $value)
                    ->addViolation();

            }
    }
}
