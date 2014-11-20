<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\Category;

class CategoryService extends BaseService
{
    private function getRepository()
    {
        return $this->em->getRepository('DmcsNotesManagerBundle:Category');
    }

    public function saveNewCategory(Category $category, $owner)
    {
        $categoryRepo = $this->getRepository();
        $exists = $categoryRepo->findOneBy(array(
            'name' => $category->getName(),
            'owner' => $owner->getId()
        ));

        if (!$exists) {
            $category->setOwner($owner);
            $this->em->persist($category);
            $this->em->flush();
            return $category->getId();
        }

        throw new \Exception('There is already a category with this name!');
    }

    public function deleteCategoryById($categoryId, $owner)
    {
        $categoryRepo = $this->getRepository();
        $category = $categoryRepo->findOneBy(array(
            'id' => $categoryId,
            'owner' => $owner->getId()
        ));

        if ($category) {
            $this->em->remove($category);
            $this->em->flush();
        }
    }

    public function findAllByOwnerId($ownerId)
    {
        return $this->getRepository()
                    ->findBy(array('owner' => $ownerId));
    }
}