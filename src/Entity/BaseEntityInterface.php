<?php
namespace Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;

Interface BaseEntityInterface
{

    public static function loadValidatorMetadata(ClassMetadata $metadata);

}
