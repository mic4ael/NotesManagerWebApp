<?php

namespace Dmcs\NotesManagerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType 
{
    public function __construct($ownerId = NULL)
    {
        $this->ownerId = $ownerId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $owner = $this->ownerId;
        $builder->add('title', 'text')
                ->add('content', 'textarea', array(
                    'attr' => array('rows' => 5)
                ))
                ->add('category', 'entity', array(
                    'class' => 'DmcsNotesManagerBundle:Category',
                    'empty_value' => 'Choose a category',
                    'query_builder' => function (EntityRepository $er) use ($owner) {
                        return $er->createQueryBuilder('c')
                                  ->where("c.owner = :ownerId")
                                  ->setParameter('ownerId', $owner);
                    }
                ))
                ->add('color', 'text')
                ->add('submit', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dmcs\NotesManagerBundle\Entity\Note'
        ));
    }

    public function getName() 
    {
        return 'note';
    }
}
