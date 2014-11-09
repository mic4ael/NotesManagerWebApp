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
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        return $this->render('DmcsNotesManagerBundle:Home:index.html.twig', array(
            'notes' => $user->getNotes()
        ));
    }

    public function editNoteAction($noteId)
    {
        
    }

    public function newNoteAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $noteService = $this->get('notes_manager.service.factory')
                            ->create('NoteService');
        $form = $this->createForm(new NoteType($user->getId()), new Note, array(
            'action' => $this->generateUrl('new_note_path')
        ));

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $noteService->saveNewNote($form->getData(), $user);
            } 
        }

        return $this->render('DmcsNotesManagerBundle:Home:new_note.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteNoteAction($noteId)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $noteService = $this->get('notes_manager.service.factory')
                            ->create('NoteService');

        $noteService->deleteById($noteId, $user);

        return $this->redirect($this->generateUrl('home_path'));
    }

    public function newCategoryAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $categoryService = $this->get('notes_manager.service.factory')
                                ->create('CategoryService');
        $form = $this->createForm(new CategoryType(), new Category, array(
            'action' => $this->generateUrl('new_category_path')
        ));

        if ($this->getRequest()->getMethod() == 'POST') {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $categoryService->saveNewCategory($form->getData(), $user);
            }
        }

        return $this->render('DmcsNotesManagerBundle:Home:new_category.html.twig', array(
            'form' => $form->createView(),
            'categories' => $user->getCategories()
        ));
    }

    public function deleteCategoryAction($categoryId)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $categoryService = $this->get('notes_manager.service.factory')
                                ->create('CategoryService');

        $categoryService->deleteCategoryById($categoryId, $user);
        return $this->redirect($this->generateUrl('new_category_path'));
    }
}
