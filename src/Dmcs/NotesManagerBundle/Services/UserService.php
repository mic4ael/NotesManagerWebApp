<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\User;
use Dmcs\NotesManagerBundle\Entity\UserRepository;

use Doctrine\ORM\EntityManager;

class UserService 
{
    protected $em;

    public function __construct(EntityManager $em) 
    {
        $this->em = $em;
    }

    public function registerUser() 
    {
        $user = new User();
        $user->setName('mic4ael');

        $this->em->persist($user);
        $this->em->flush();

        return 'register' . $user->getId();
    }

    public function loginUser()
    {
        return 'login';
    }
}
