<?php

namespace FreeNote\FreeNoteBundle\Builder;

use Doctrine\Common\Persistence\ObjectRepository;
use Sylius\Bundle\SalesBundle\Builder\OrderBuilder as BaseOrderBuilder;
use Sylius\Bundle\SalesBundle\Model\OrderInterface;
use Sylius\Bundle\CartBundle\Provider\CartProviderInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * Order builder.
 */
class OrderBuilder extends BaseOrderBuilder
{
    private $cartProvider;
    private $securityContext;

    public function __construct(ObjectRepository $orderRepository, ObjectRepository $itemRepository, CartProviderInterface $cartProvider, SecurityContextInterface $securityContext)
    {
        $this->cartProvider = $cartProvider;
        $this->securityContext = $securityContext;

        parent::__construct($orderRepository, $itemRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function build(OrderInterface $order)
    {
        $order->getItems()->clear();

        $cart = $this->cartProvider->getCart();

        if ($cart->isEmpty()) {
            throw new \LogicException('The cart must not be empty.');
        }

        $order->setUser($this->securityContext->getToken()->getUser());

        foreach ($cart->getItems() as $item) {
            $orderItem = $this->createNewItem();

            $orderItem->setSellable($item->setSellable());
            $orderItem->setQuantity($item->getQuantity());
            $orderItem->setUnitPrice($item->setSellable()->getPrice());

            $order->addItem($orderItem);
        }

        $order->calculateTotal();
    }
}
