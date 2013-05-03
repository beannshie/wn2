<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class MusicGenreType extends ArticleCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('origin', 'sylius_categorizer_category_choice', array(
            'label' => 'fn.label.music_genre.origin',
            'help_block' => 'fn.help.music_genre.origin',
            'required' => false,
            'multiple' => false,
            'empty_value' => 'wybierz gatunek',
            'catalog'  => 'origin'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_music_genre';
    }
}
