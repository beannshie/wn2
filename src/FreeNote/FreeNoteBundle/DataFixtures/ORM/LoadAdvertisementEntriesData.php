<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default advertisement to play with.
 */
class LoadAdvertisementEntriesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $cats = array('Zespoły', 'Początkujące', 'Współpracujące z WN', 'Płyty',
            'Recenzje', 'Koncerty', 'Festiwale', 'Dyskografie', 'Literatura', 'Biografie');

        for ($i = 1; $i <= 50; $i++) {
            $post = $this->get('free_note.repository.advertisement_entry')->createNew();

            $post->setTitle($this->faker->sentence);
            $post->setCity($this->faker->city);
            $post->setContent($this->faker->paragraph(9));
            $post->setCreatedBy($this->getReference('User-'.rand(1, 15)));
            $post->setUpdatedBy($this->faker->userName);
            if($i%2)
            {
                $post->setImageFilename('t-shirt.jpg');
                $post->setImagePath('../../bundles/freenote/images/t-shirt.jpg');
                $post->setImageMimeType('image/jpg');
                $post->setImageSize(123);
                $post->setImageAlt('tiszert');
                $post->setImageTitle('Koszulek');
            }

            $randomA = $this->faker->randomElement($cats);
            $randomB = $this->faker->randomElement($cats);
            while ($randomA == $randomB)
            {
                $randomB = $this->faker->randomElement($cats);
            }

            $categories = array(
                $this->getReference('Sandbox.Advertisement.Category.'.$randomA),
                $this->getReference('Sandbox.Advertisement.Category.'.$randomB)
            );

            $post->setCategories(new ArrayCollection($categories));

            $manager->persist($post);

            $this->setReference('Sandbox.Advertisement.Entry-'.$i, $post);

            if (0 === $i % 20) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 13;
    }
}
