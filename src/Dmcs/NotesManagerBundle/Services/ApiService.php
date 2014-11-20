<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Factories\ServicesFactory;
use Dmcs\NotesManagerBundle\Entity\Note;
use Dmcs\NotesManagerBundle\Entity\Category;

class ApiService extends BaseService
{
    private function getRepository($repoType)
    {
        return $this->em->getRepository("DmcsNotesManagerBundle:${repoType}");
    }

    private function getService($type)
    {
        return $this->servicesFactory->create("${type}Service");
    }

    public function setFactory($factory)
    {
        $this->servicesFactory = $factory;
        return $this;
    }

    public function getNotes($params, $controller)
    {
        $noteService = $this->getService('Note');
        $notes = $noteService->findAllByOwnerId($params['ownerId']);

        return array(
            'success' => true,
            'message' => json_encode($notes),
        );
    }

    public function getCategories($params, $controller)
    {
        $categoryService = $this->getService('Category');
        $categories = $categoryService->findAllByOwnerId($params['ownerId']);

        return array(
            'success' => true,
            'message' => json_encode($categories)
        );
    }

    public function createNote($params, $controller)
    {
        $user = $this->getRepository('User')->findOneById($params['ownerId']);
        if (!$user) {
            throw new \Exception('No such user!');
        }

        $noteService = $this->getService('Note');
        $note = new Note;
        $note->setTitle($params['title'])
             ->setContent($params['content']);

        $noteId = $noteService->saveNote($note, $user);
        return array(
            'success' => true,
            'message' => $noteId
        );
    }

    public function createCategory($params, $controller)
    {
        $user = $this->getRepository('User')->findOneById($params['ownerId']);
        if (!$user) {
            throw new \Exception('No such user!');
        }
        
        $categoryService = $this->getService('Category');
        $categoryRepository = $this->getRepository('Category');
        $category = new Category;
        $category->setName($params['name']);

        $categoryId = $categoryService->saveNewCategory($category, $user);
        return array(
            'success' => true,
            'message' => $categoryId
        );
    }

    public function registerUser($params, $controller)
    {
        $userService = $this->getService('User');
    }
}