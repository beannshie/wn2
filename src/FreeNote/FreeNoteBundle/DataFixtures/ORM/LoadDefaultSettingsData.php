<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\SettingsBundle\Model\Settings;

/**
 * Store default settings.
 */
class LoadDefaultSettingsData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $manager = $this->getSettingsManager();

        $general = array(
            'siteName'               => 'Sylius',
            'siteUrl'                => 'demo.sylius.org',
            'defaultMetaTitle'       => 'Sylius - Symfony2 e-commerce',
            'defaultMetaDescription' => 'Sylius is an e-commerce solution for Symfony2',
            'defaultMetaKeywords'    => 'symfony2, webshop, ecommerce, e-commerce, sylius, shopping cart'
        );

        $manager->saveSettings('general', new Settings($general));

        $taxation = array(
            'defaultTaxZone' => $this->getReference('Zone-EU')
        );

        $manager->saveSettings('taxation', new Settings($taxation));
    }

    public function getOrder()
    {
        return 3;
    }

    private function getSettingsManager()
    {
        return $this->get('sylius.settings.manager');
    }
}
