<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Dmcs\NotesManagerBundle\Form\Type\UserType;
use Dmcs\NotesManagerBundle\Entity\User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user); 
        return $this->render('DmcsNotesManagerBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'method' => 'POST',
            'action' => '/login'
        ));
    }

    public function registerAction()
    {
        return $this->render('DmcsNotesManagerBundle:Default:index.html.twig'); 
    }
}
