<?php

namespace Constraint;

use Symfony\Component\Validator\Constraint;

/*
 * Example validator which validates a field in a database table for uniqueness
 */
class Unique extends Constraint
{
    public $message = 'This field must contain a unique value.';
    public $table;
    public $field;

    public function validatedBy()
    {
        return 'validator.unique';
    }
}
