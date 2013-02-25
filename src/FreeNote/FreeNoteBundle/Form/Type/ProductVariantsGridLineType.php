<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\AssortmentBundle\Form\Type\VariantType as BaseVariantType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Product variant line for simple grid form.
 */
class ProductVariantsGridLineType extends BaseVariantType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sku', 'text')
            ->add('price', 'money')
            ->add('onHand', 'integer', array(
                'label' => 'Stock "on hand"'
            ))
            ->add('availableOnDemand', 'checkbox', array(
                'label' => 'Available on demand'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_product_variants_grid_line';
    }
}
