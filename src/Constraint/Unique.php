<?php

namespace Constraint;

use Symfony\Component\Validator\Constraint;

/*
 * Example validator which validates a field in a database table for uniqueness
 */
class Unique extends Constraint
{
    public $notUniqueMessage = '%string% has already been used.';
    public $entity;
    public $field;

    public function validatedBy()
    {
        return 'validator.unique';
    }
}
