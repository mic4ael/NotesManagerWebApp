<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dmcs\NotesManagerBundle\Form\Type\UserType;
use Dmcs\NotesManagerBundle\Form\Type\RegistrationType;
use Dmcs\NotesManagerBundle\Form\Model\Registration;
use Dmcs\NotesManagerBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('register_path'),
        ));

        $registration = new Registration();
        $registrationForm = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('register_path'),
        ));

        return $this->render('DmcsNotesManagerBundle:Default:index.html.twig', array(
            'login_form' => $form->createView(),
            'registration_form' => $registrationForm->createView(),
        ));
    }
}
