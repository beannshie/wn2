<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType as BaseShippingMethodType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Custom shipping method form.
 * We need to add the zone select field.
 */
class ShippingMethodType extends BaseShippingMethodType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('zone', 'sylius_zone_choice')
        ;
    }
}
