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
    public function validateCoachSalary(Coach $coach){
        $club=$coach->getClub();

        $salary = $coach->getSalary();
        $clubBudget = $club->getBudget();

        if(($clubBudget - $salary)<0){
         throw new \Exception('Coach salary exceeds club budget or gives zero or less');
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
        $this->validateCoachSalary($coach);
    }
}
