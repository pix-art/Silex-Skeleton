<?php

namespace Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;

class UniqueValidator extends ConstraintValidator
{
    private $em;

    public function validate($value, Constraint $constraint)
    {
        $exists = $this->em
             ->getRepository($constraint->entity)
             ->findOneBy(array($constraint->field => $value));

        if ($exists) {
            $this->context->addViolation($constraint->notUniqueMessage, array('%string%' => $value));

            return false;
        }

        return true;
    }

    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }
}
