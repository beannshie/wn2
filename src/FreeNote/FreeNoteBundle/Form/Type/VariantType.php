<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\AssortmentBundle\Form\Type\VariantType as BaseVariantType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Product variant type. We need to add only simple price field and inventory tracking field for quantity.
 */
class VariantType extends BaseVariantType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('sku', 'text', array(
                'label' => 'SKU'
            ))
            ->add('price', 'money')
            ->add('onHand', 'integer', array(
                'label' => 'Stock "on hand"'
            ))->add('availableOnDemand', 'checkbox', array(
                'label' => 'Available on demand'
            ))
            ->add('shippingCategory', 'sylius_shipping_category_choice', array(
                'required' => false,
                'label'    => 'Shipping category'
            ))
        ;
    }
}
