<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\Note;

class NoteService extends BaseService
{
    private function getRepository()
    {
        return $this->em->getRepository('DmcsNotesManagerBundle:Note');
    }

    private function _findByOwnerAndId($noteId, $ownerId)
    {
        $noteRepo = $this->getRepository();
        return $noteRepo->findOneBy(array(
            'id' => $noteId,
            'owner' => $ownerId
        ));
    }

    public function findByOwnerAndId($noteId, $ownerId)
    {
        return $this->_findByOwnerAndId($noteId, $ownerId);
    }

    public function saveNote(Note $form, $owner)
    {
        $note = new Note;
        $note->setTitle($form->getTitle())
             ->setContent($form->getContent())
             ->setCategory($form->getCategory())
             ->setOwner($owner)
             ->setColor($form->getColor());

        $this->em->persist($note);
        $this->em->flush();

        return true;
    }

    public function updateNote(Note $note)
    {
        $this->em->persist($note);
        $this->em->flush();
    }

    public function deleteById($noteId, $user)
    {
        $note = $this->_findByOwnerAndId($noteId, $user->getId());

        if ($note) {
            $this->em->remove($note);
            $this->em->flush();
        }
    }
}