<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\User;
use Dmcs\NotesManagerBundle\Entity\UserRepository;
use Dmcs\NotesManagerBundle\Form\RegistrationType;

class UserService extends BaseService
{
    public function registerUser(RegistrationType $form)
    {
        $user = new User();

        $this->em->persist($user);
        $this->em->flush();

        return $user->getId();
    }
}
