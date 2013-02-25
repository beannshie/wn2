<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\AddressingBundle\Model\ZoneInterface;
use Sylius\Bundle\TaxationBundle\Entity\TaxRate as BaseTaxRate;

/**
 * Tax rate entity.
 */
class TaxRate extends BaseTaxRate
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
