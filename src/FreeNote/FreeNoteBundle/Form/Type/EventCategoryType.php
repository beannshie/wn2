<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

class EventCategoryType extends ArticleCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_event_category';
    }
}
