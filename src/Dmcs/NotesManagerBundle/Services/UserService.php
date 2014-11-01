<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\User;
use Dmcs\NotesManagerBundle\Entity\UserRepository;
use Dmcs\NotesManagerBundle\Form\Model\Registration;

class UserService extends BaseService
{
    public function registerUser(Registration $form)
    {
        $user = new User();
        $user->setUsername($form->getUsername())
             ->setEmail($form->getEmail())
             ->setPassword($form->getPassword());
             
        $this->em->persist($user);
        $this->em->flush();

        return $user->getId();
    }
}
