<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dmcs\NotesManagerBundle\Form\Type\RegistrationType;
use Dmcs\NotesManagerBundle\Form\Model\Registration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class AuthController extends Controller
{
    public function registerAction()
    {
        $userService = $this->get('notes_manager.service.factory')
                            ->create('UserService');
        $userService->setEncoderFactory($this->get('security.encoder_factory'));

        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->handleRequest($this->getRequest());

        if ($form->isValid()) {
            try {
                $userService->registerUser($form->getData());
            } catch (\Exception $ex) {
                return $this->forward('DmcsNotesManagerBundle:Default:index', array(
                    'uniquenessError' => $ex->getMessage(),
                ));
            }

            return $this->redirect($this->generateUrl('dmcs_notes_manager_homepage'));
        }

        return $this->forward('DmcsNotesManagerBundle:Default:index', array(
            'registrationErrors' => (string) $form->getErrors(true),
        ));
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } else if (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        return $this->forward(
            'DmcsNotesManagerBundle:Default:index',
            array('error' => $error)
        );
    }
}
