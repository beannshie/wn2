<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

class NewsEntryType extends ArticleEntryType
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
                'label' => 'fn.label.news.news_entry.author'
            ))
            ->add('categories', 'sylius_categorizer_category_choice', array(
                'multiple' => true,
                'required' => true,
                'catalog'  => fnCategoryInterface::FN_CATEGORY_NEWS_SLUG,
                'label' => 'fn.label.article.article_entry.categories'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_news_entry';
    }
}
