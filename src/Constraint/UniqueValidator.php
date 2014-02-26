<?php

namespace Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueValidator extends ConstraintValidator
{
    private $orm;

    public function validate($value, Constraint $constraint)
    {
        $exists = $this->orm
             ->getRepository($constraint->entity)
             ->findOneBy(array($constraint->field => $value));

        if ($exists) {
            $this->context->addViolation($constraint->notUniqueMessage, array('%string%' => $value));

            return false;
        }

        return true;
    }

    public function setOrm($orm)
    {
        $this->orm = $orm;
    }
}
