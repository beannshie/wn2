<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FreeNote\FreeNoteBundle\Entity\User;

/**
 * User fixtures.
 */
class LoadUsersData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $userProfileManager = $this->getUserProfileManager();
        $userProfileRepository = $this->getUserProfileRepository();

        $user = new User();

        $user->setUsername('administrator');
        $user->setEmail('administrator@example.com');
        $user->setPlainPassword('abrakadabra');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));

        $manager->persist($user);
        $manager->flush();

        $user->setUsername('kaala');
        $user->setEmail('kaala@example.com');
        $user->setPlainPassword('halfvren');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setSuperAdmin(true);

        $manager->persist($user);
        $manager->flush();

        $this->setReference('User-Administrator', $user);

        for ($i = 1; $i <= 15; $i++) {
            $user = new User();
            $userProfile = $userProfileRepository->createNew();

            $username = $this->faker->username;

            $user->setUsername($username);
            $user->setEmail($username.'@example.com');
            $user->setPlainPassword($username);
            $user->setEnabled(true);
            $user->setRoles(array('ROLE_USER'));

            $userProfile->setUser($user);
            $userProfile->setName($this->faker->firstName);
            $userProfile->setSurname($this->faker->lastName);
            $userProfile->setPhoneNumber($this->faker->phoneNumber);
            $userProfile->setAvatarPath('../../bundles/freenote/images/mug.jpg');
            $userProfile->setPostalAddress($this->getReference('Address-'.$i));
            $userProfile->setBusinessAddress($this->getReference('Address-'.($i+20)));
            $userProfile->setCompanyName($this->faker->company);
            $userProfile->setNip($this->faker->randomNumber(3).'-'.$this->faker->randomNumber(3).'-'.$this->faker->randomNumber(2).'-'.$this->faker->randomNumber(2));
            $userProfile->setRegon($this->faker->randomNumber(9));

            //$userProfileManager->persist($userProfile);
            $user->setUserProfile($userProfile);
            $manager->persist($user);

            $this->setReference('User-'.$i, $user);
        }

        //$userProfileManager->flush();

        $manager->flush();

    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }

    private function getUserProfileManager()
    {
        return $this->get('free_note.manager.user_profile');
    }

    private function getUserProfileRepository()
    {
        return $this->get('free_note.repository.user_profile');
    }
}
