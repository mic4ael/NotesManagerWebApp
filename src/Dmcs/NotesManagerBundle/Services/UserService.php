<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\User;
use Dmcs\NotesManagerBundle\Entity\UserRepository;
use Dmcs\NotesManagerBundle\Form\UserType;

class UserService extends BaseService
{
    public function registerUser(RegisterType $userForm)
    {
        $user = new User();
        $user->setUsername()
             ->setPassword()
             ->setEmail();

        $this->em->persist($user);
        $this->em->flush();

        return 'register' . $user->getId();
    }

    public function loginUser()
    {
        return 'login';
    }
}
