<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Factories\ServicesFactory;
use Dmcs\NotesManagerBundle\Entity\Note;
use Dmcs\NotesManagerBundle\Entity\Category;
use Dmcs\NotesManagerBundle\Form\Model\Registration;

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

    public function setEncoderFactory($encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        return $this;
    }

    public function getNotes($params)
    {
        $noteService = $this->getService('Note');
        $notes = $noteService->findAllByOwnerId($params['ownerId']);
        $result = [];
        foreach ($notes as $note) {
            $result[] = $note->jsonSerialize();
        }

        return array(
            'success' => true,
            'message' => json_encode($result),
        );
    }

    public function getCategories($params)
    {
        $categoryService = $this->getService('Category');
        $categories = $categoryService->findAllByOwnerId($params['ownerId']);
        $result = [];
        foreach ($categories as $category) {
            $result[] = $category->jsonSerialize();
        }

        return array(
            'success' => true,
            'message' => json_encode($result)
        );
    }

    public function createNote($params)
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

    public function createCategory($params)
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

    public function registerUser($params)
    {
        $userService = $this->getService('User');
        $userService->setEncoderFactory($this->encoderFactory);
        $regForm = new Registration;
        $regForm->setUsername($params['username'])
                ->setEmail($params['email'])
                ->setPassword($params['password']);

        return array(
            'success' => true,
            'message' => $userService->registerUser($regForm)
        );
    }

    public function getUser($params)
    {
        $user = $this->getRepository('User')->findOneByUsername($params['username']);
        return array(
            'success' => TRUE,
            'message' => $user !== null ? $user->getId() : NULL
        );
    }
}