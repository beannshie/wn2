<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\AssortmentBundle\Form\Type\CustomizableProductType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Handy form for editing all product variants at once.
 */
class ProductVariantsGridType extends CustomizableProductType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('variants', 'collection', array(
                'type' => 'free_note_product_variants_grid_line'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'free_note_product_variants_grid';
    }
}
