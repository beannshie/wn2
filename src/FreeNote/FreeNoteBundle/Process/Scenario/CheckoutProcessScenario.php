<?php

namespace FreeNote\FreeNoteBundle\Process\Scenario;

use Sylius\Bundle\FlowBundle\Process\Builder\ProcessBuilderInterface;
use Sylius\Bundle\FlowBundle\Process\Scenario\ProcessScenarioInterface;
use FreeNote\FreeNoteBundle\Process\Step;
use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Example sandbox checkout process.
 */
class CheckoutProcessScenario extends ContainerAware implements ProcessScenarioInterface
{
    /**
     * {@inheritdoc}
     */
    public function build(ProcessBuilderInterface $builder)
    {
        $cart = $this->container->get('sylius.cart_provider')->getCart();

        $builder
            ->add('security', new Step\SecurityCheckoutStep())
            ->add('addressing', new Step\AddressingCheckoutStep())
            ->add('shipping', new Step\ShippingCheckoutStep())
            ->add('finalize', new Step\FinalizeCheckoutStep())
            ->setDisplayRoute('free_note_checkout_display')
            ->setForwardRoute('free_note_checkout_forward')
            ->setRedirect('free_note_core_frontend')

            ->validate(function () use ($cart) {
                return !$cart->isEmpty();
            })
        ;
    }
}
