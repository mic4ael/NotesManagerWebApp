<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $noteService = $this->get('notes_manager.service.factory')
                            ->create('NoteService');

        return $this->render('DmcsNotesManagerBundle:Home:index.html.twig', array(
            'notes' => array()
        ));
    }

    public function newNoteAction()
    {
        return $this->render('DmcsNotesManagerBundle:Home:new_note.html.twig');
    }

    public function newCategoryAction()
    {
        return $this->render('DmcsNotesManagerBundle:Home:new_category.html.twig');
    }

    public function listNotesAction()
    {
        return null;
    }
}
