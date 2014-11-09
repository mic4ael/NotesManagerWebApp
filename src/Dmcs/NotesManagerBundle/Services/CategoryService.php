<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\Category;

class CategoryService extends BaseService
{
    public function saveNewCategory(Category $category, $owner)
    {
        $category->setOwner($owner);
        $this->em->persist($category);
        $this->em->flush();
    }
}