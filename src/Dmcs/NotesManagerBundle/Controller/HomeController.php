<?php

namespace Dmcs\NotesManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Dmcs\NotesManagerBundle\Form\Type\NoteType;
use Dmcs\NotesManagerBundle\Form\Type\CategoryType;
use Dmcs\NotesManagerBundle\Entity\Note;
use Dmcs\NotesManagerBundle\Entity\Category;

class HomeController extends Controller
{
    private function getLoggedUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

    public function indexAction()
    {
        $user = $this->getLoggedUser();

        return $this->render('DmcsNotesManagerBundle:Home:index.html.twig', array(
            'notes' => $user->getNotes()
        ));
    }

    public function editNoteAction($noteId)
    {
        $loggedUser = $this->getLoggedUser();
        $noteService = $this->get('notes_manager.service.factory')
                     ->create('NoteService');
        $note = $noteService->findByOwnerAndId($noteId, $loggedUser->getId());

        if (!$note) {
            return $this->redirect($this->generateUrl('home_path'));
        }
        
        $form = $this->createForm(new NoteType($loggedUser->getId()), $note, array(
            'action' => $this->generateUrl('edit_note_path', array('noteId' => $note->getId()))
        ));

        if ($this->getRequest()->getMethod() === 'POST') {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $noteService->updateNote($form->getData());
            }
        }

        return $this->render('DmcsNotesManagerBundle:Home:new_note.html.twig', array(
            'form' => $form->createView(),
            'message' => NULL
        ));
    }

    public function newNoteAction()
    {
        $user = $this->getLoggedUser();
        $noteService = $this->get('notes_manager.service.factory')
                            ->create('NoteService');
        $form = $this->createForm(new NoteType($user->getId()), new Note, array(
            'action' => $this->generateUrl('new_note_path')
        ));
        $blankForm = clone $form;

        $message = NULL;
        if ($this->getRequest()->getMethod() == 'POST') {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $noteService->saveNote($form->getData(), $user);
                $message = 'Note saved';
                $form = $blankForm;
            } 
        }

        return $this->render('DmcsNotesManagerBundle:Home:new_note.html.twig', array(
            'form' => $form->createView(),
            'message' => $message
        ));
    }

    public function deleteNoteAction($noteId)
    {
        $user = $this->getLoggedUser();
        $noteService = $this->get('notes_manager.service.factory')
                            ->create('NoteService');

        $noteService->deleteById($noteId, $user);

        return $this->redirect($this->generateUrl('home_path'));
    }

    public function newCategoryAction()
    {
        $user = $this->getLoggedUser();
        $categoryService = $this->get('notes_manager.service.factory')
                                ->create('CategoryService');
        $form = $this->createForm(new CategoryType(), new Category, array(
            'action' => $this->generateUrl('new_category_path')
        ));
        $blankForm = clone $form;

        $message = NULL;
        if ($this->getRequest()->getMethod() == 'POST') {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $persisted = $categoryService->saveNewCategory($form->getData(), $user);
                $message = $persisted ? 'Category saved' : 'This name is not unique';
                if ($persisted) $form = $blankForm;
            }
        }

        return $this->render('DmcsNotesManagerBundle:Home:new_category.html.twig', array(
            'form' => $form->createView(),
            'categories' => $user->getCategories(),
            'message' => $message
        ));
    }

    public function deleteCategoryAction($categoryId)
    {
        $user = $this->getLoggedUser();
        $categoryService = $this->get('notes_manager.service.factory')
                                ->create('CategoryService');

        $categoryService->deleteCategoryById($categoryId, $user);
        return $this->redirect($this->generateUrl('new_category_path'));
    }
}
