<?php
namespace Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;

abstract class BaseModel implements BaseModelInterface
{
    /**
     * Declare this function in your model to add constraints to your variables
     **/

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
    }

    /**
     * This is a magic function that will put every
     * private variable into an array with the name
     * CAPITALIZED as key and the data it contains as value
     **/

    public function toColumn()
    {
        $array = array();
        $class_vars = get_object_vars($this);

        foreach ($class_vars as $name => $value) {
            $array[strtoupper($name)] = utf8_decode($value);
        }

        return $array;
    }

    /**
     * This is a magic counter function for toColumn.
     * It will transform every variable in your array into
     * lowercase and search this model for a private
     * variable that has the same name. Then it will map
     * the data from the array with the model via the
     * set function.
     **/

    public function fromColumn(array $data)
    {
        foreach ($data as $key => $value) {
            $ucfirst = ucfirst(strtolower($key));
            $name = 'set'.$ucfirst;

            if (method_exists($this, $name)) {
                $this->$name(utf8_encode($value));
            }
        }
    }

}
