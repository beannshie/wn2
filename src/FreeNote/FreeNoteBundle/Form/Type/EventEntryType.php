<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

class EventEntryType extends ArticleEntryType
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
                'label' => 'fn.label.event.event_entry.author'
            ))
            ->add('place', 'text', array(
                'required' => false,
                'label' => 'fn.label.event.event_entry.place'
            ))
            ->add('categories', 'sylius_categorizer_category_choice', array(
                'multiple' => true,
                'required' => true,
                'catalog'  => fnCategoryInterface::FN_CATEGORY_EVENT_SLUG,
                'label' => 'fn.label.article.article_entry.categories'
            ))
            ->add('tickets', 'text', array(
                'required' => false,
                'label' => 'fn.label.event.event_entry.tickets'
            ))
            ->add('startDate', 'datetime', array(
                'required' => true,
                'date_format' => 'y-M-d',
                'date_widget' => 'choice',
                'time_widget' => 'text',
                'label' => 'fn.label.event.event_entry.start_date'
            ))
            ->add('endDate', 'datetime', array(
                'required' => false,
                'date_format' => 'y-M-d',
                'date_widget' => 'choice',
                'time_widget' => 'text',
                'label' => 'fn.label.event.event_entry.end_date'
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
        return 'free_note_event_entry';
    }
}
