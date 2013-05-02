<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

class AdvertisementEntryType extends ArticleEntryType
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
                'label' => 'fn.label.advertisement.advertisement_entry.author'
            ))
            ->add('city', 'text', array(
                'required' => false,
                'label' => 'fn.label.advertisement.advertisement_entry.place'
            ))
            ->add('categories', 'sylius_categorizer_category_choice', array(
                'multiple' => true,
                'required' => true,
                'catalog'  => fnCategoryInterface::FN_CATEGORY_ADVERTISEMENT_SLUG,
                'label' => 'fn.label.article.article_entry.categories'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_advertisement_entry';
    }
}
