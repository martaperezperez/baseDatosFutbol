<?php

namespace App\Validator;

use App\Entity\Club;
use App\Entity\Coach;
use App\Entity\Player;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SalaryValidator extends ConstraintValidator
{
    public function validatePlayerSalary(Player $player , Club $club)
    {
        /* @var App\Validator\Salary $constraint */

        $playerSalary = $player->getSalary();
        $clubBudget = $club->getBudget();

        if ($playerSalary > $clubBudget) {
            throw new \Exception('Player salary exceeds club budget');
        }

        return true;
    }
    public function validateCoachSalary(Coach $coach , Club $club)
    {
        /* @var App\Validator\Salary $constraint */

        $playerSalary = $coach->getSalary();
        $clubBudget = $club->getBudget();

        if ($playerSalary > $clubBudget) {
            throw new \Exception('Coach salary exceeds club budget');
        }

        return true;
    }


    public function validate(mixed $value, Constraint $constraint)
    {
        // TODO: Implement validate() method.
    }
}
