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
            'siteName'               => 'Wolna Nuta',
            'siteUrl'                => 'wolnanuta.pl',
            'defaultMetaTitle'       => 'Wolna Nuta - serwis muzyki alternatywnej',
            'defaultMetaDescription' => 'Wolna Nuta - serwis muzyki alternatywnej',
            'defaultMetaKeywords'    => 'wolna nuta, muzyka, sklep, alternatywna'
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
