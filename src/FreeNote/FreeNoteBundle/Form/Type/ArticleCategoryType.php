<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\CategorizerBundle\Form\Type\NestedCategoryType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleCategoryType extends NestedCategoryType
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
                'label' => 'fn.label.article.article_category.image',
                'image_path' => 'imageWebPath',
                'image_filter' => 'icon'
            ))
            ->add('image_alt', 'text', array(
                'label' => 'fn.label.article.article_category.image_alt'
            ))
            ->add('image_title', 'text', array(
                'label' => 'fn.label.article.article_category.image_title'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_article_category';
    }
}
