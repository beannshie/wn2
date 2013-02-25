<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Sylius\Bundle\TaxationBundle\Form\Type\TaxRateType as BaseTaxRateType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Custom tax rate form.
 * We need to add the zone select field.
 */
class TaxRateType extends BaseTaxRateType
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
