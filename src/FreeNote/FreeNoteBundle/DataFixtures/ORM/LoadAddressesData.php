<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default addresssing fixtures to play with Sylius sandbox.
 */
class LoadAddressesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $addressManager = $this->getAddressManager();
        $addressRepository = $this->getAddressRepository();

        for ($i = 1; $i <= 100; $i++) {
            $address = $addressRepository->createNew();

            $address->setFirstname($this->faker->firstName);
            $address->setLastname($this->faker->lastName);
            $address->setCity($this->faker->city);
            $address->setStreet($this->faker->streetAddress);
            $address->setPostcode($this->faker->postcode);

            do {
                $isoName = $this->faker->countryCode;
            } while ('UK' === $isoName);

            $country = $this->getReference('Country-'.$isoName);
            $province = $country->hasProvinces() ? $this->faker->randomElement($country->getProvinces()) : null;

            $address->setCountry($country);
            $address->setProvince($province);

            $addressManager->persist($address);

            $this->setReference('Address-'.$i, $address);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }

    private function getAddressManager()
    {
        return $this->get('sylius.manager.address');
    }

    private function getAddressRepository()
    {
        return $this->get('sylius.repository.address');
    }
}
