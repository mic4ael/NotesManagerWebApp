<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render('DmcsNotesManagerBundle:Home:index.html.twig');
    }

    public function newNoteAction()
    {

    }

    public function listNotesAction()
    {
        
    }
}
