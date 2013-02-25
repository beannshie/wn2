<?php

namespace FreeNote\FreeNoteBundle\EventListener;

use Doctrine\Common\Persistence\ObjectRepository;
use FreeNote\FreeNoteBundle\Entity\Order;
use Sylius\Bundle\ShippingBundle\Calculator\CalculatorInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * This listener calculates the shipping charge
 */
class OrderShippingListener
{
    /**
     * Adjustment repository.
     *
     * @var ObjectRepository
     */
    private $adjustmentRepository;

    /**
     * Shipping charges calculator.
     *
     * @var ShippingChargeCalculator
     */
    private $calculator;

    /**
     * Constructor.
     *
     * @param ObjectRepository    $adjustmentRepository
     * @param CalculatorInterface $calculator
     */
    public function __construct(ObjectRepository $adjustmentRepository, CalculatorInterface $calculator)
    {
        $this->adjustmentRepository = $adjustmentRepository;
        $this->calculator = $calculator;
    }

    /**
     * Calculate shipment charges on the order.
     *
     * @param GenericEvent $event
     */
    public function processShippingCharges(GenericEvent $event)
    {
        $order = $event->getSubject();

        foreach ($order->getShipments() as $shipment) {
            $adjustment = $this->adjustmentRepository->createNew();

            $charge = $this->calculator->calculate($shipment);

            $adjustment->setLabel(Order::SHIPPING_ADJUSTMENT);
            $adjustment->setAmount($charge);
            $adjustment->setDescription($shipment->getMethod()->getName());

            $order->addAdjustment($adjustment);
        }

        $order->calculateTotal();
    }
}
