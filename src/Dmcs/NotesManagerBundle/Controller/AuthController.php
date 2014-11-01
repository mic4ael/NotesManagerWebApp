<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dmcs\NotesManagerBundle\Form\Type\RegistrationType;
use Dmcs\NotesManagerBundle\Form\Model\Registration;

class AuthController extends Controller
{
    public function registerAction()
    {
        $userService = $this->get('notes_manager.service.factory')
                            ->create('UserService');

        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            $isUnique = $userService->registerUser($form->getData());
            if (!$isUnique) {
                return $this->forward('DmcsNotesManagerBundle:Default:index', array(
                    'isUnique' => false,
                ));
            }

            return $this->redirect($this->generateUrl('dmcs_notes_manager_homepage'));
        } else {
            return $this->forward('DmcsNotesManagerBundle:Default:index', array(
                'registrationErrors' => 'Passwords are not the same',
            ));
        }
    }

    public function loginAction()
    {

    }
}
