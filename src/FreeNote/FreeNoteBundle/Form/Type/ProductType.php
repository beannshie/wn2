<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\AssortmentBundle\Form\Type\CustomizableProductType as BaseCustomizableProductType;
use FreeNote\FreeNoteBundle\Entity\Product;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Product form type.
 * Extends customizable form type, we just need to add category choice.
 *
 * Also we add a simple choice field to determine how product variants should
 * be selected, matched against combination of option or just list them all.
 */
class ProductType extends BaseCustomizableProductType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('image', 'file', array(
                'required' => false
            ))
            ->add('taxCategory', 'sylius_tax_category_choice', array(
                'required' => false,
                'label'    => 'Taxation category'
            ))
            ->add('taxons', 'sylius_taxon_selection')
            ->add('variantPickingMode', 'choice', array(
                'label'   => 'Variant picking mode',
                'choices' => Product::getVariantPickingModeChoices()
            ))
        ;
    }
}
