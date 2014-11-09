<?php

namespace Dmcs\NotesManagerBundle\Factories;

use Doctrine\ORM\EntityManager;
use Dmcs\NotesManagerBundle\Services\UserService;
use Dmcs\NotesManagerBundle\Services\NoteService;
use Dmcs\NotesManagerBundle\Services\CategoryService;

final class ServicesFactory {
    private static $em;

    public function __construct(EntityManager $em) {
        self::$em = $em;
    }

    public static function create($serviceType) {
        switch ($serviceType) {
            case 'UserService':
                return new UserService(self::$em);

            case 'NoteService':
                return new NoteService(self::$em);

            case 'CategoryService':
                return new CategoryService(self::$em);
            
            default:
                throw new \Exception("No such service");
                break;
        }
    }
}