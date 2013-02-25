<?php

namespace FreeNote\FreeNoteBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Finalize checkout step.
 * It builds the order from cart.
 * Defines the shipment and method.
 */
class FinalizeCheckoutStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $order = $this->prepareOrder($context);

        return $this->render('FreeNoteBundle:Frontend/Checkout/Step:finalize.html.twig', array(
            'context' => $context,
            'order'   => $order
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function forwardAction(ProcessContextInterface $context)
    {
        $order = $this->prepareOrder($context);

        $this->save($order);

        $this->container->get('session')->setFlash('success', 'Your order has been saved, thank you!');
        $this->container->get('sylius.cart_provider')->abandonCart();

        return $this->complete();
    }

    public function save(OrderInterface $order)
    {
        $manager = $this->container->get('sylius.manager.order');

        $manager->persist($order);
        $manager->flush();
    }

    /**
     * Prepare order.
     *
     * @param ProcessContextInterface $context
     *
     * @return OrderInterface
     */
    private function prepareOrder(ProcessContextInterface $context)
    {
        $order = $this->container->get('sylius.repository.order')->createNew();

        $deliveryAddress = $this->getAddress($context->getStorage()->get('delivery.address'));
        $billingAddress = $this->getAddress($context->getStorage()->get('billing.address'));

        $shippingMethod = $this->getShippingMethod($context->getStorage()->get('shipping-method'));

        $shipment = $this->createNewShipment();
        $shipment->setMethod($shippingMethod);

        foreach ($order->getInventoryUnits() as $item) {
            $shipment->addItem($item);
        }

        $order->addShipment($shipment);

        $order->setDeliveryAddress($deliveryAddress);
        $order->setBillingAddress($billingAddress);

        $orderBuilder = $this->container->get('free_note.builder.order');
        $orderBuilder->build($order);

        $this->container->get('event_dispatcher')->dispatch('sylius.order.pre_create', new GenericEvent($order));

        return $order;
    }

    private function getAddress($id)
    {
        $addressRepository = $this->container->get('sylius.repository.address');

        return $addressRepository->find($id);
    }

    private function getShippingMethod($id)
    {
        $shippingMethodRepository = $this->container->get('sylius.repository.method');

        return $shippingMethodRepository->find($id);
    }

    private function createNewShipment()
    {
        return $this->get('sylius.repository.shipment')->createNew();
    }
}
