<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class EventEntryType extends ArticleEntryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('author', 'text', array(
                'required' => false,
                'label' => 'fn.label.event.event_entry.author'
            ))
            ->add('place', 'text', array(
                'required' => false,
                'label' => 'fn.label.event.event_entry.place'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_event_entry';
    }
}
