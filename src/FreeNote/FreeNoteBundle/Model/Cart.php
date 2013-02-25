<?php

namespace FreeNote\FreeNoteBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Bundle\CartBundle\Entity\Cart as BaseCart;
use Sylius\Bundle\ShippingBundle\Model\ShippablesAwareInterface;

/**
 * Cart entity.
 */
class Cart extends BaseCart implements ShippablesAwareInterface
{
    /**
     * {@inheritdoc}
     */
    public function getShippables()
    {
        $shippables = new ArrayCollection();

        foreach($this->items as $item) {
            $shippables->add($item->getVariant());
        }

        return $shippables;
    }
}
