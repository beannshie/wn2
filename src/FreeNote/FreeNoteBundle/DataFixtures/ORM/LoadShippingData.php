<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\ShippingBundle\Calculator\DefaultCalculators;
use Sylius\Bundle\ShippingBundle\Model\ShippingCategoryInterface;

/**
 * Default shipping component configuration.
 */
class LoadShippingData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $regular = $this->createShippingCategory('Regular', 'Regular weight items', 'Regular');
        $heavy = $this->createShippingCategory('Heavy', 'Heavy items', 'Heavy');

        $this->createShippingMethod('FedEx', 'USA GMT-8', null, DefaultCalculators::FLEXIBLE_RATE, array('first_item_cost' => 10.00, 'additional_item_cost' => 5.00, 'additional_item_limit' => 0));
        $this->createShippingMethod('UPS Ground', 'EU', null, DefaultCalculators::FLAT_RATE, array('amount' => 25.00));
        $this->createShippingMethod('DHL', 'EU', null, DefaultCalculators::FLAT_RATE, array('amount' => 23.50));
        $this->createShippingMethod('FedEx World Shipping', 'Rest of world', null, DefaultCalculators::FLEXIBLE_RATE, array('first_item_cost' => 40.00, 'additional_item_cost' => 5.00, 'additional_item_limit' => 10));
        $this->createShippingMethod('International Shipping', 'Rest of world', null, DefaultCalculators::FLAT_RATE, array('amount' => 50.00));

        $manager->flush();
    }

    private function createShippingCategory($name, $description, $referenceName)
    {
        $category = $this
            ->getShippingCategoryRepository()
            ->createNew()
        ;

        $category->setName($name);
        $category->setDescription($description);

        $this
            ->getShippingCategoryManager()
            ->persist($category)
        ;

        $this->setReference('ShippingCategory.'.$referenceName, $category);

        return $category;
    }

    /**
     * Create shipping method.
     *
     * @param string                    $name
     * @param string                    $zone
     * @param ShippingCategoryInterface $category
     * @param string                    $calculator
     */
    private function createShippingMethod($name, $zone, ShippingCategoryInterface $category = null, $calculator = DefaultCalculators::PER_ITEM_RATE, array $configuration = array())
    {
        $method = $this
            ->getShippingMethodRepository()
            ->createNew()
        ;

        $method->setCategory($category);
        $method->setZone($this->getZone($zone));
        $method->setName($name);
        $method->setCalculator($calculator);
        $method->setConfiguration($configuration);

        $this
            ->getShippingMethodManager()
            ->persist($method)
        ;

        $this->setReference('ShippingMethod.'.$name, $method);
    }

    public function getOrder()
    {
        return 4;
    }

    private function getZone($name)
    {
        return $this->getReference('Zone-'.$name);
    }

    private function getShippingCategoryManager()
    {
        return $this->get('sylius.manager.shipping_category');
    }


    private function getShippingCategoryRepository()
    {
        return $this->get('sylius.repository.shipping_category');
    }

    private function getShippingMethodManager()
    {
        return $this->get('sylius.manager.shipping_method');
    }

    private function getShippingMethodRepository()
    {
        return $this->get('sylius.repository.shipping_method');
    }
}
