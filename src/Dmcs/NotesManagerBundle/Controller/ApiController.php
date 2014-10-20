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
        if (!in_array($method, $this->allowedMethods))
        {
            return $response->setData(array(
                'message' => 'Access Denied',
                'success' => false
            ));
        }

        $userService = $this->get('notes_manager.user.service');
        $response->setData(array(
            'message' => call_user_func(array($userService, $method)),
            'success' => true
        ));

        return $response;
    }
}
