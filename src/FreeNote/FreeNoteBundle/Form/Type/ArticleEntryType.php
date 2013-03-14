<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\BloggerBundle\Form\Type\PostType as BasePostType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Sandbox blog post form type.
 * Adds category choice field.
 */
class ArticleEntryType extends BasePostType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('categories', 'sylius_categorizer_category_choice', array(
                'multiple' => true,
                'catalog'  => 'artykuly'
            ))
            ->add('content', 'textarea', array(
                'label' => 'sylius_blogger.label.post.content',
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'my' // simple, medium, advanced, bbcode
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_article_entry';
    }
}
