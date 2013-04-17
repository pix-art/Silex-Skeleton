<?php

namespace Exceptions;

class ValidationException extends \Exception {

    private $errors;

    public function __construct(array $errors) 
    {
    	$this->errors = $errors;
    }

    public function setErrors(array $errors) {
        $this->errors = $errors;
    }

    public function getErrors() {
        return $this->errors;
    }
}