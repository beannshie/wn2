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
        $user = new User();

        $user->setUsername('administrator');
        $user->setEmail('administrator@example.com');
        $user->setPlainPassword('abrakadabra');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SYLIUS_ADMIN'));

        $manager->persist($user);
        $manager->flush();

        $this->setReference('User-Administrator', $user);

        for ($i = 1; $i <= 15; $i++) {
            $user = new User();

            $username = $this->faker->username;

            $user->setUsername($username);
            $user->setEmail($username.'@example.com');
            $user->setPlainPassword($username);
            $user->setEnabled(true);

            $manager->persist($user);

            $this->setReference('User-'.$i, $user);
        }

        $manager->flush();

    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
