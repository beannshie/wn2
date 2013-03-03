<?php

namespace FreeNote\FreeNoteBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\AssortmentBundle\Entity\Variant\Variant as BaseVariant;
use Sylius\Bundle\SalesBundle\Model\SellableInterface;
use Sylius\Bundle\SalesBundle\Model\OrderItemInterface;
use Sylius\Bundle\InventoryBundle\Model\StockableInterface;
use Sylius\Bundle\ShippingBundle\Model\ShippableInterface;
use Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sandbox product variant entity.
 */
class Variant extends BaseVariant implements StockableInterface, ShippableInterface, SellableInterface
{
    protected $sku;

    /**
     * Variant price.
     *
     * @Assert\NotBlank
     *
     * @var float
     */
    protected $price;

    /**
     * On hand stock.
     *
     * @Assert\NotBlank
     * @Assert\Min(0)
     *
     * @var integer
     */
    protected $onHand;

    protected $shippingCategory;

    /**
     * Is variant available on demand?
     *
     * @var Boolean
     */
    protected $availableOnDemand;

    /**
     * Items in order.
     *
     * @var Collection
     */
    protected $items;

    /**
     * Items total.
     *
     * @var mixed
     */
    protected $itemsTotal;

    /**
     * Override constructor to set on hand stock.
     */
    public function __construct()
    {
        parent::__construct();

        $this->price = 0.00;
        $this->onHand = 1;
        $this->availableOnDemand = true;
        $this->items = new ArrayCollection();
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price.
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * {@inheritdoc}
     */
    public function isInStock()
    {
        return 0 < $this->onHand;
    }

    /**
     * {@inheritdoc}
     */
    public function getOnHand()
    {
        return $this->onHand;
    }

    /**
     * {@inheritdoc}
     */
    public function setOnHand($onHand)
    {
        $this->onHand = $onHand;

        if (0 > $this->onHand) {
            $this->onHand = 0;
        }
    }

    public function getInventoryName()
    {
        return $this->product->getName();
    }

    public function isAvailableOnDemand()
    {
        return $this->availableOnDemand;
    }

    public function setAvailableOnDemand($availableOnDemand)
    {
        $this->availableOnDemand = (Boolean) $availableOnDemand;
    }

    public function getShippingCategory()
    {
        if (null === $this->shippingCategory && !$this->isMaster() && null !== $product = $this->getProduct()) {
            return $product->getMasterVariant()->getShippingCategory();
        }

        return $this->shippingCategory;
    }

    public function setShippingCategory(ShippingCategoryInterface $category = null)
    {
        $this->shippingCategory = $category;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function setItems(Collection $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearItems()
    {
        $this->items->clear();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function countItems()
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(OrderItemInterface $item)
    {
        if (!$this->hasItem($item)) {
            $item->setOrder($this);
            $this->items->add($item);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeItem(OrderItemInterface $item)
    {
        if ($this->hasItem($item)) {
            $item->setOrder(null);
            $this->items->removeElement($item);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem(OrderItemInterface $item)
    {
        return $this->items->contains($item);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }

    /**
     * {@inheritdoc}
     */
    public function setItemsTotal($itemsTotal)
    {
        $this->itemsTotal = $itemsTotal;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateItemsTotal()
    {
        $itemsTotal = 0;

        foreach ($this->items as $item) {
            $item->calculateTotal();

            $itemsTotal += $item->getTotal();
        }

        $this->itemsTotal = $itemsTotal;

        return $this;
    }

    /**
     * Get the name of item which will be displayed in orders.
     *
     * @return string
     */
    public function getSellableName()
    {
        return $this->__toString();
    }

    public function __toString()
    {
        return $this->getInventoryName();
    }
}
