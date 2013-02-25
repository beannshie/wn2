<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\InventoryBundle\Entity\InventoryUnit as BaseInventoryUnit;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\ShippingBundle\Model\ShipmentInterface;
use Sylius\Bundle\ShippingBundle\Model\ShipmentItemInterface;
use Sylius\Bundle\ShippingBundle\Model\ShippableInterface;

/**
 * Custom inventory unit class.
 * Can be attached to order.
 */
class InventoryUnit extends BaseInventoryUnit implements ShipmentItemInterface
{
    /**
     * Order.
     *
     * @var OrderInterface
     */
    protected $order;

    /**
     * Shipment.
     *
     * @var ShipmentInterface
     */
    protected $shipment;

    /**
     * Shipping state.
     *
     * @var string
     */
    protected $shippingState;

    public function __construct()
    {
        parent::__construct();

        $this->shippingState = ShipmentItemInterface::STATE_READY;
    }

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
    public function setOrder(OrderInterface $order = null)
    {
        $this->order = $order;
    }

    public function getShipment()
    {
        return $this->shipment;
    }

    public function setShipment(ShipmentInterface $shipment = null)
    {
        $this->shipment = $shipment;
    }

    public function getShippable()
    {
        return $this->stockable;
    }

    public function setShippable(ShippableInterface $shippable)
    {
        $this->shippable = $shippable;
    }

    public function getShippingState()
    {
        return $this->shippingState;
    }

    public function setShippingState($state)
    {
        $this->shippingState = $state;
    }
}
