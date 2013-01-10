<?php

namespace Sylius\Bundle\SandboxBundle\Process\Step;

use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ContainerAwareStep;

/**
 * Billing step.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BillingStep extends ContainerAwareStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $address = $this->getAddress($context->getStorage()->get('billing.address'));
        $form = $this->createAddressForm($address);

        return $this->container->get('templating')->renderResponse('SyliusSandboxBundle:Frontend/Checkout/Step:billing.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $context->getRequest();
        $form = $this->createAddressForm();

        if ($request->isMethod('POST') && $form->bindRequest($request)->isValid()) {
            $address = $form->getData();
            $this->saveAddress($address);

            $context->getStorage()->set('billing.address', $address->getId());

            return $this->complete();
        }

        return $this->container->get('templating')->renderResponse('SyliusSandboxBundle:Frontend/Checkout/Step:billing.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    private function saveAddress(AddressInterface $address)
    {
        $addressManager = $this->container->get('sylius_addressing.manager.address');

        $addressManager->persist($address);
        $addressManager->flush($address);
    }

    private function getAddress($id)
    {
        $addressRepository = $this->container->get('sylius_addressing.repository.address');

        return $addressRepository->find($id);
    }

    private function createAddressForm(AddressInterface $address = null)
    {
        return $this->container->get('form.factory')->create('sylius_addressing_address', $address);
    }
}
