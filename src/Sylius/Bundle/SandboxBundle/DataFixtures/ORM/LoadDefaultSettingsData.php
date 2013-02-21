<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\SettingsBundle\Model\Settings;

/**
 * Store default settings.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
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
        return 4;
    }

    private function getSettingsManager()
    {
        return $this->get('sylius.settings.manager');
    }
}
