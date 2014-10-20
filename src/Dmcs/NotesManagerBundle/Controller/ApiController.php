<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    private $allowedMethods = array(
        'loginUser',
        'registerUser',
        'getNote'
    );

    public function routeAction($method) 
    {
        $response = new JsonResponse();
        $userService = $this->get('notes_manager.user.service');
        $response->setData(array(
            'method' => call_user_func(array($userService, $method)),
        ));

        return $response;
    }
}
