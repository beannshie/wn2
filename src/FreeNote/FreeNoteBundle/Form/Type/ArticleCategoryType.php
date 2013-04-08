<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\CategorizerBundle\Form\Type\NestedCategoryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sylius\Bundle\CategorizerBundle\Form\EventListener\BuildNestedCategoryTypeListener;
use Symfony\Component\Form\AbstractType;

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
                'help_block' => 'W przypadku braku, aplikacja wygeneruje domyślny opis na podstawie nazwy kategorii.'
            ))
            ->add('image_title', 'text', array(
                'required' => false,
                'label' => 'fn.label.article.article_category.image_title',
                'help_block' => 'Nazwa ta wyświetli się, jeśli plik graficzny nie zostanie znaleziony. W przypadku braku, aplikacja wygeneruje domyślny tytuł na podstawie nazwy kategorii.'
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
