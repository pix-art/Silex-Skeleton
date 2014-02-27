<?php
namespace Entity;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;
use Constraint\ContainsAlphanumeric;
use Constraint\Unique;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Example implements BaseEntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\Column(type="datetime")
    */
    private $last_updated;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $email;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersistPreUpdate()
    {
        $this->last_updated = new \DateTime();
    }

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
        //This can be used to compare a values uniqueness to the database via orm
        //$metadata->addPropertyConstraint('email', new Unique(array('field' => 'email', 'entity' => $metadata->getReflectionClass()->getName())));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Example
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender
     *
     * @param  string  $gender
     * @return Example
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set email
     *
     * @param  string  $email
     * @return Example
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set last_updated
     *
     * @param  \DateTime $lastUpdated
     * @return Example
     */
    public function setLastUpdated($lastUpdated)
    {
        $this->last_updated = $lastUpdated;

        return $this;
    }

    /**
     * Get last_updated
     *
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->last_updated;
    }
}
