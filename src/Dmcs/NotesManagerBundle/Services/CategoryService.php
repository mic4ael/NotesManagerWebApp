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

    public function deleteCategoryById($categoryId, $owner)
    {
        $categoryRepo = $this->em->getRepository('DmcsNotesManagerBundle:Category');
        $category = $categoryRepo->find($categoryId);

        if ($category && $category->getOwner()->getId() === $owner->getId()) {
            $this->em->remove($category);
            $this->em->flush();
        }
    }
}