<?php

namespace App\Validator;

use App\Entity\Coach;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CoachSalaryValidator extends ConstraintValidator
{

    /**
     * @throws \Exception
     */
    public function validateCoachSalary(Coach $coach): bool{

        $club=$coach->getClub();
if($club !== null) {
    $salary = $coach->getSalary();
    $clubBudget = $club->getBudget();

     return !(($clubBudget - $salary) < 0);



}
        return true;
}


    /**
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\CoachSalary $constraint */


        $coach= $this->context->getRoot()->getData();

       if( !$this->validateCoachSalary($coach)){
           $this->context->buildViolation($constraint->message)
               ->setParameter('{{ salary }}', $value)
               ->addViolation();
       }



    }
}
