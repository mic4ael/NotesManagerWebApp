<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
    private $allowedMethods = array(
        'login',
        'register',
        'getNote'
    );

    public function routeAction($page) 
    {
        return array();
    }
}
