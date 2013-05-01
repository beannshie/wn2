<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class NewsCategoryType extends ArticleCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_news_category';
    }
}
