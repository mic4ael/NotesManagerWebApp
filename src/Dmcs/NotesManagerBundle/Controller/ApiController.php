<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    private $allowedMethods = array(
        'registerUser',
        'getNotes',
        'getCategories',
        'createNote',
        'createCategory',
        'getUser'
    );

    public function routeAction($method = null) 
    {
        $response = new JsonResponse();
        if (is_null($method) || !in_array($method, $this->allowedMethods))
        {
            return $response->setData(array(
                'message' => 'Access Denied',
                'success' => false
            ));
        }

        $params = json_decode($this->getRequest()->getContent(), true);
        $factory = $this->get('notes_manager.service.factory');
        $apiService = $factory->create('ApiService')
                              ->setFactory($factory)
                              ->setEncoderFactory($this->get('security.encoder_factory'));
        try {
            $result = call_user_func_array(array($apiService, $method), array($params, $this));
        } catch (\Exception $ex) {
            return $response->setData(array(
                'message' => $ex->getMessage(),
                'success' => false
            ));
        }

        return $response->setData(array(
            'message' => $result['message'],
            'success' => $result['success']
        ));
    }
}
