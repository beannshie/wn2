<?php

namespace FreeNote\FreeNoteBundle\Process\Step;

use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;

/**
 * The addressing step of checkout.
 * User enters the delivery and shipping address.
 */
class AddressingCheckoutStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $form = $this->createCheckoutAddressingForm();

        return $this->render('FreeNoteBundle:Frontend/Checkout/Step:addressing.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->getRequest();
        $form = $this->createCheckoutAddressingForm();

        if ($request->isMethod('POST') && $form->bindRequest($request)->isValid()) {
            $data = $form->getData();

            $deliveryAddress = $data['deliveryAddress'];
            $billingAddress = $data['billingAddress'];

            $this->saveAddress($deliveryAddress);
            $this->saveAddress($billingAddress);

            $context->getStorage()->set('delivery.address', $deliveryAddress->getId());
            $context->getStorage()->set('billing.address', $billingAddress->getId());

            return $this->complete();
        }

        return $this->render('FreeNoteBundle:Frontend/Checkout/Step:addressing.html.twig', array(
            'form'    => $form->createView(),
            'context' => $context
        ));
    }

    private function createCheckoutAddressingForm()
    {
        return $this->createForm('free_note_checkout_addressing');
    }

    private function saveAddress(AddressInterface $address)
    {
        $addressManager = $this->get('sylius.manager.address');

        $addressManager->persist($address);
        $addressManager->flush($address);
    }

    private function getAddress($id)
    {
        $addressRepository = $this->container->get('sylius.repository.address');

        return $addressRepository->find($id);
    }
}
