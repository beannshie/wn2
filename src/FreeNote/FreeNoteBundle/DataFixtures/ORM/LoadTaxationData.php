<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\TaxationBundle\Model\TaxCategoryInterface;

/**
 * Default taxation configuration.
 */
class LoadTaxationData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $taxableGoods = $this->createTaxCategory('Taxable goods', 'Default taxation category', 'Default');
        $this->createTaxRate($taxableGoods, 'Default Tax', 0.23, 'EU + USA GMT-8');
        $this->createTaxRate($taxableGoods, 'EU VAT', 0.23, 'EU');

        $clothing = $this->createTaxCategory('Clothing', 'All clothing goods', 'Clothing');
        $this->createTaxRate($clothing, 'Clothing US Tax', 0.08, 'USA GMT-8');
        $this->createTaxRate($clothing, 'Clothing EU Tax', 0.10, 'EU', true);

        $manager->flush();
    }

    private function createTaxCategory($name, $description, $referenceName)
    {
        $category = $this
            ->getTaxCategoryRepository()
            ->createNew()
        ;

        $category->setName($name);
        $category->setDescription($description);

        $this
            ->getTaxCategoryManager()
            ->persist($category)
        ;

        $this->setReference('TaxCategory.'.$referenceName, $category);

        return $category;
    }

    /**
     * Create tax rate.
     *
     * @param TaxCategoryInterface $category
     * @param string               $name
     * @param float                $amount
     * @param string               $zone
     * @param string               $calculator
     */
    private function createTaxRate(TaxCategoryInterface $category, $name, $amount, $zone, $includedInPrice = false, $calculator = 'default')
    {
        $rate = $this
            ->getTaxRateRepository()
            ->createNew()
        ;

        $rate->setCategory($category);
        $rate->setZone($this->getZone($zone));
        $rate->setName($name);
        $rate->setAmount($amount);
        $rate->setIncludedInPrice($includedInPrice);
        $rate->setCalculator($calculator);

        $this
            ->getTaxRateManager()
            ->persist($rate)
        ;

        $this->setReference('TaxRate.'.$name, $rate);
    }

    public function getOrder()
    {
        return 4;
    }

    private function getZone($name)
    {
        return $this->getReference('Zone-'.$name);
    }

    private function getTaxCategoryManager()
    {
        return $this->get('sylius.manager.tax_category');
    }


    private function getTaxCategoryRepository()
    {
        return $this->get('sylius.repository.tax_category');
    }

    private function getTaxRateManager()
    {
        return $this->get('sylius.manager.tax_rate');
    }

    private function getTaxRateRepository()
    {
        return $this->get('sylius.repository.tax_rate');
    }
}
