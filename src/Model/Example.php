<?php
namespace Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Constraint\ContainsAlphanumeric;

class Example extends BaseModel
{

    protected $name;
    protected $email;
    protected $gender;

    /**
     * Set all your constraints
     */

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank(array('message' => 'fill_in_field')));
        $metadata->addPropertyConstraint('name', new ContainsAlphanumeric());
        $metadata->addPropertyConstraint('name', new Assert\Length(array('min' => 5, 'minMessage' => 'input_to_short')));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank(array('message' => 'fill_in_field')));
        $metadata->addPropertyConstraint('email', new Assert\Email(array('message' => 'incorrect_email')));
        $metadata->addPropertyConstraint('gender', new Assert\NotBlank(array('message' => 'fill_in_field')));
        $metadata->addPropertyConstraint('gender', new Assert\Choice(array(
            'choices' => array('male', 'female'),
            'message' => 'choose_gender',
        )));
    }

    /**
     * Gets the value of name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name.
     *
     * @param mixed $name the name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the value of gender.
     *
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Sets the value of gender.
     *
     * @param mixed $gender the gender
     *
     * @return self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }
}
