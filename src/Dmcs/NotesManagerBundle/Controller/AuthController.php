<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dmcs\NotesManagerBundle\Form\Type\RegistrationType;

class AuthController extends Controller
{
    public function registerAction()
    {
        $userService = $this->get('notes_manager.service.factory')
                            ->create('UserService');
        $form = new RegistrationType();

        $form->handleRequest($this->getRequest());
        
        if ($form->isValid()) {
            $userService->registerUser($form);
        }
    }

    public function loginAction()
    {

    }
}
