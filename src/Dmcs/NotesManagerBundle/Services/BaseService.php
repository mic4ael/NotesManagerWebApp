<?php

namespace Dmcs\NotesManagerBundle\Services;

use Doctrine\ORM\EntityManager;

class BaseService 
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }    
}