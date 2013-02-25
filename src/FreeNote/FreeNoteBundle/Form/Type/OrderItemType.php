<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\SalesBundle\Form\Type\OrderItemType as BaseOrderItemType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Item form type.
 */
class OrderItemType extends BaseOrderItemType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $factory = $builder->getFormFactory();

        $listener = function (FormEvent $event) use ($factory) {
            $form = $event->getForm();
            $item = $event->getData();

            if (null === $item) {
                return;
            }

            $disabled = null !== $item->getId();

            $form
                ->remove('variant')
                ->add(
                    $factory->createNamed('variant', 'sylius_variant_to_identifier', $item->getSellable(), array(
                        'identifier' => 'sku',
                        'disabled'   => $disabled
                    ))
                )
            ;
        };

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, $listener)
            ->add('variant', 'sylius_variant_to_identifier', array(
                'identifier' => 'sku'
            ))
        ;
    }
}
