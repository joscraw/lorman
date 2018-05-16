<?php

namespace App\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Stateful model class that holds data, validation, and business logic
 *
 * @author Josh Crawmer <jcrawmer@lorman.com> - wishful thinking ;)
 */
class Contact
{

    private $fullName;

    private $email;

    private $phone;

    private $message;

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    /**
     * Add validation Constraints to the Contact object
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('fullName', new Assert\NotBlank());
        $metadata->addPropertyConstraints(
            'email',
            [new Assert\NotBlank(), new Assert\Email(array('checkMX' => true))]
        );
        $metadata->addPropertyConstraint(
            'phone',
            new Assert\Regex(array('pattern' => '/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/'))
        );
        $metadata->addPropertyConstraint('message', new Assert\NotBlank());
    }

}