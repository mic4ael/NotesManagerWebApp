<?php

namespace Dmcs\NotesManagerBundle\Services;

use Dmcs\NotesManagerBundle\Entity\User;
use Dmcs\NotesManagerBundle\Entity\UserRepository;
use Dmcs\NotesManagerBundle\Form\Model\Registration;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class UserService extends BaseService
{
    private $encoderFactory;

    public function setEncoderFactory(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        return $this;
    }

    public function registerUser(Registration $form)
    {
        if ($this->checkIsUnique($form)) {
            $user = new User();
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setUsername($form->getUsername())
                 ->setEmail($form->getEmail())
                 ->setPassword($encoder->encodePassword($form->getPassword(), $user->getSalt()));

            $this->em->persist($user);
            $this->em->flush();

            return $user->getId();
        }

        throw new \Exception("Provided email or username is not unique");
    }

    public function findOneByUsername($username)
    {
        return $this->em->getRepository('DmcsNotesManagerBundle:User')
                    ->findOneByUsername($username);
    }

    private function checkIsUnique($form)
    {
        $userRepository = $this->em->getRepository('DmcsNotesManagerBundle:User');
        return $userRepository->findOneByUsername($form->getUsername()) === null &&
               $userRepository->findOneByEmail($form->getEmail()) === null;
    }

    public function checkPassword($username, $password)
    {
        $user = $this->findOneByUsername($username);
        if ($user === null)
            return false;

        $encoder = $this->encoderFactory->getEncoder($user);
        return $encoder->encodePassword($password, $user->getSalt()) === $user->getPassword();
    }
}
