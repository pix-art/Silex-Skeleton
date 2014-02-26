<?php

namespace Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/*
 * This is where the validation happens. Notice the constructor taking a
 * $db object and called by our UniqueValidatorServiceProvider.php
 */
class UniqueValidator extends ConstraintValidator
{
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function validate($value, Constraint $constraint)
    {
        $sql = sprintf('SELECT id FROM %s WHERE %s = ?', $constraint->table, $constraint->field);

        $exists = $this->db->fetchColumn($sql, array($value));

        if ($exists) {
            $this->context->addViolation($constraint->message);

            return false;
        }

        return true;
    }
}
