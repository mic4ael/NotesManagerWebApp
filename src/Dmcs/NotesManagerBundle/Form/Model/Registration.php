<?php

namespace Dmcs\NotesManagerBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Registration
{
    /*
     * @Assert\NotBlank()
     */
    private $username;

    /*
     * @Assert\NotBlank();
     */
    private $password;

    /*
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
}