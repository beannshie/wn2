<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\BloggerBundle\Form\Type\PostType as BasePostType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleEntryType extends BasePostType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('image', 'file', array(
                'required' => false,
                'label' => 'fn.label.article.article_entry.image'
            ))
            ->add('image_alt', 'text', array(
                'label' => 'fn.label.article.article_entry.image_alt'
            ))
            ->add('image_title', 'text', array(
                'label' => 'fn.label.article.article_entry.image_title'
            ))
            ->add('categories', 'sylius_categorizer_category_choice', array(
                'multiple' => true,
                'catalog'  => 'artykuly',
                'label' => 'fn.label.article.article_entry.categories'
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
