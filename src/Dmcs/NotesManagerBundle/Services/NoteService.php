<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\Note;

class NoteService extends BaseService
{
    public function saveNewNote(Note $form, $owner)
    {
        $note = new Note;
        $note->setTitle($form->getTitle())
             ->setContent($form->getContent())
             ->setOwner($owner)
             ->setColor('color');

        $this->em->persist($note);
        $this->em->flush();
    }

    public function deleteById($noteId, $user)
    {
        $noteRepo = $this->em->getRepository('DmcsNotesManagerBundle:Note');
        $note = $noteRepo->find($noteId);

        if ($note && $note->getOwner()->getId() === $user->getId()) {
            $this->em->remove($note);
            $this->em->flush();
        }
    }
}