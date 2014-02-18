<?php
namespace Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;

Interface BaseModelInterface
{

    public static function loadValidatorMetadata(ClassMetadata $metadata);

    public function toColumn();

    public function fromColumn(array $data);

}
