<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\AddressingBundle\Model\ZoneInterface;
use Sylius\Bundle\ShippingBundle\Entity\ShippingMethod as BaseShippingMethod;

/**
 * Custom shipping method model.
 * Shipping methods in current implementation are also "limited" by zones.
 */
class ShippingMethod extends BaseShippingMethod
{
    protected $zone;

    public function getZone()
    {
        return $this->zone;
    }

    public function setZone(ZoneInterface $zone = null)
    {
        $this->zone = $zone;
    }
}
