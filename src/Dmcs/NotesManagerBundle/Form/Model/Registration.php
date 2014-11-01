<?php

namespace Dmcs\NotesManagerBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/*
 * @UniqueEntity(fields="username", message="This username is already taken")
 * @UniqueEntity(fields="email", message="This email is already taken")
 */
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
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
}