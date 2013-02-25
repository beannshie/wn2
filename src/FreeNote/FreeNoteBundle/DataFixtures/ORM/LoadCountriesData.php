<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Symfony\Component\Locale\Locale;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default country fixtures.
 */
class LoadCountriesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $countryRepository = $this->getCountryRepository();

        $countries = Locale::getDisplayCountries('en');

        foreach ($countries as $isoName => $name) {
            $country = $countryRepository->createNew();

            $country->setName($name);
            $country->setIsoName($isoName);

            if ('US' === $isoName) {
                $this->loadProvinces($country);
            }

            $manager->persist($country);

            $this->setReference('Country-'.$isoName, $country);
        }

        $manager->flush();
    }

    private function loadProvinces($country)
    {
        $states = array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District Of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming'
        );

        $provinceRepository = $this->getProvinceRepository();

        foreach ($states as $isoName => $name) {
            $province = $provinceRepository->createNew();
            $province->setName($name);

            $country->addProvince($province);

            $this->setReference('Province-'.$isoName, $province);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    private function getCountryRepository()
    {
        return $this->get('sylius.repository.country');
    }

    private function getProvinceRepository()
    {
        return $this->get('sylius.repository.province');
    }
}
