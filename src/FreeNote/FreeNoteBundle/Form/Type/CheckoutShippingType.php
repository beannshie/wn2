<?php

namespace FreeNote\FreeNoteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Checkout shipping step form type.
 */
class CheckoutShippingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('method', 'sylius_shipping_method_choice', array(
                'shippables' => $options['shippables'],
                'criteria'   => $options['criteria'],
                'expanded'   => true,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => null
            ))
            ->setRequired(array(
                'shippables'
            ))
            ->setOptional(array(
                'criteria'
            ))
            ->setAllowedTypes(array(
                'shippables' => 'Sylius\Bundle\ShippingBundle\Model\ShippablesAwareInterface',
                'criteria'   => array('array')
            ))
        ;
    }

    public function getName()
    {
        return 'free_note_checkout_shipping';
    }
}
