<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Builds some simple orders to play with Sylius sandbox.
 */
class LoadOrdersData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $repository = $this->getOrderRepository();
        $orderManager = $this->getOrderManager();
        $eventDispatcher = $this->container->get('event_dispatcher');

        for ($i = 1; $i <= 100; $i++) {
            $order = $repository->createNew();
            $this->buildOrder($order, $i);

            //$eventDispatcher->dispatch('sylius.order.pre_create', new GenericEvent($order));

            $orderManager->persist($order);
            $eventDispatcher->dispatch('sylius.order.post_create', new GenericEvent($order));
            $this->setReference('Order-'.$i, $order);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 8;
    }

    /**
     * Creates sample cart for order.
     *
     * @param OrderInterface $order
     */
    private function buildOrder(OrderInterface $order, $pk)
    {
        $itemRepository = $this->getOrderItemRepository();
        $itemManager = $this->getOrderItemManager();
        $totalVariants = SYLIUS_ASSORTMENT_FIXTURES_TV;

        $order->getItems()->clear();

        $totalItems = rand(3, 6);
        for ($i = 0; $i <= $totalItems; $i++) {
            $variant = $this->getReference('Variant-'.rand(1, $totalVariants - 1));

            $item = $itemRepository->createNew();
            $item->setQuantity(rand(1, 5));
            $item->setSellable($variant);
            $item->setUnitPrice($variant->getPrice());
            $itemManager->persist($item);

            $order->addItem($item);
        }

        $shipment = $this->createNewShipment();
        $shipment->setMethod($this->getReference('ShippingMethod.UPS Ground'));

        foreach ($order->getInventoryUnits() as $item) {
            $shipment->addItem($item);
        }

        $order->addShipment($shipment);

        $order->setUser($this->getReference('User-'.rand(1, 15)));
        $order->setDeliveryAddress($this->getReference('Address-'.rand(1, 50)));
        $order->setBillingAddress($this->getReference('Address-'.rand(1, 50)));

        $order->setNumber($pk.'/'.date('Y'));

        $order->calculateTotal();
    }

    private function getOrderManager()
    {
        return $this->get('sylius.manager.order');
    }

    private function getOrderRepository()
    {
        return $this->get('sylius.repository.order');
    }

    private function getOrderItemManager()
    {
        return $this->get('sylius.manager.order_item');
    }

    private function getOrderItemRepository()
    {
        return $this->get('sylius.repository.order_item');
    }

    private function createNewShipment()
    {
        return $this->get('sylius.repository.shipment')->createNew();
    }
}
