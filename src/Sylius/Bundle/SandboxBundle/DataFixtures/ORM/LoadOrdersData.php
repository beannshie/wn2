<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Builds some simple orders to play with Sylius sandbox.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class LoadOrdersData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $repository = $this->container->get('sylius_sales.repository.order');
        $eventDispatcher = $this->container->get('event_dispatcher');

        for ($i = 1; $i <= 100; $i++) {
            $order = $repository->createNew();
            $this->buildOrder($order);

            $eventDispatcher->dispatch('sylius_sales.order.pre_create', new GenericEvent($order));

            $manager->persist($order);
            $eventDispatcher->dispatch('sylius_sales.order.post_create', new GenericEvent($order));
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
    private function buildOrder(OrderInterface $order)
    {
        $itemRepository = $this->getOrderItemRepository();
        $totalVariants = SYLIUS_ASSORTMENT_FIXTURES_TV;

        $order->getItems()->clear();

        $totalItems = rand(3, 6);
        for ($i = 0; $i <= $totalItems; $i++) {
            $variant = $this->getReference('Variant-'.rand(1, $totalVariants - 1));

            $item = $itemRepository->createNew();
            $item->setQuantity(rand(1, 5));
            $item->setVariant($variant);
            $item->setUnitPrice($variant->getPrice());

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
