<?php

namespace Dmcs\NotesManagerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NoteType extends AbstractType 
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text')
                ->add('content', 'text')
                ->add('category', 'text')
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
