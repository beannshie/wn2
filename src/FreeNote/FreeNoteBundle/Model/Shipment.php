<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\ShippingBundle\Entity\Shipment as BaseShipment;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;

/**
 * Shipment attached to order.
 */
class Shipment extends BaseShipment
{
    /**
     * Order.
     *
     * @var OrderInterface
     */
    protected $order;

    /**
     * Get order.
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order.
     *
     * @param OrderInterface $order
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }
}
