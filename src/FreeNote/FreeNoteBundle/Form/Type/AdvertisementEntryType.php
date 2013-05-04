<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
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
                'label' => 'fn.label.advertisement.advertisement_entry.city'
            ))
            ->add('categories', 'sylius_categorizer_category_choice', array(
                'multiple' => true,
                'required' => true,
                'catalog'  => fnCategoryInterface::FN_CATEGORY_ADVERTISEMENT_SLUG,
                'label' => 'fn.label.article.article_entry.categories'
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('allEntry'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_advertisement_entry';
    }
}
