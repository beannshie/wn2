<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\AssortmentBundle\Model\Variant\VariantInterface;
use Sylius\Bundle\CartBundle\Entity\CartItem as BaseCartItem;
use Sylius\Bundle\CartBundle\Model\CartItemInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cart item entity.
 */
class CartItem extends BaseCartItem
{
    /**
     * Variant.
     *
     * @Assert\NotBlank(groups={"CheckVariant"})
     *
     * @var VariantInterface
     */
    protected $variant;

    /**
     * Get associated variant.
     *
     * @return VariantInterface
     */
    public function getVariant()
    {
        return $this->variant;
    }

    /**
     * Set associated variant.
     *
     * @param VariantInterface $variant
     */
    public function setVariant(VariantInterface $variant)
    {
        $this->variant = $variant;

        $this->setUnitPrice($variant->getPrice());
    }

    /**
     * {@inheritdoc}
     */
    public function equals(CartItemInterface $item)
    {
        return $this->getVariant()->getId() === $item->getVariant()->getId();
    }
}
