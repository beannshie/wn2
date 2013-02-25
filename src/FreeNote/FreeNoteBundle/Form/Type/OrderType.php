<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\SalesBundle\Form\Type\OrderType as BaseOrderType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Order form type.
 * Adds address to assign it to order.
 */
class OrderType extends BaseOrderType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('deliveryAddress', 'sylius_address')
            ->add('billingAddress', 'sylius_address')
        ;
    }
}
