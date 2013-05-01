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
        $builder->remove('parent');
        $builder
            ->add('ancestor', 'sylius_categorizer_category_choice', array(
                'label' => 'sylius_categorizer.label.category.parent',
                'required' => true,
                'multiple' => false,
                'catalog'  => $options['catalog']
            ))
            ->add('image', 'file', array(
                'required' => false,
                'label' => 'fn.label.article.article_category.image',
                'image_path' => 'imageWebPath',
                'image_filter' => 'icon'
            ))
            ->add('image_alt', 'text', array(
                'required' => false,
                'label' => 'fn.label.article.article_category.image_alt',
                'help_block' => 'fn.help.image_alt'
            ))
            ->add('image_title', 'text', array(
                'required' => false,
                'label' => 'fn.label.article.article_category.image_title',
                'help_block' => 'fn.help.image_title'
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
