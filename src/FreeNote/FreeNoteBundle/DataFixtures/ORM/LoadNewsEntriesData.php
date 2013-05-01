<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default news to play with.
 */
class LoadNewsEntriesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $cats = array('Zespoły', 'Początkujące', 'Współpracujące z WN', 'Płyty',
            'Recenzje', 'Koncerty', 'Festiwale', 'Dyskografie', 'Literatura', 'Biografie');

        for ($i = 1; $i <= 50; $i++) {
            $post = $this->get('free_note.repository.news_entry')->createNew();

            $post->setTitle($this->faker->sentence);
            $post->setAuthor($this->faker->name);
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
                $this->getReference('Sandbox.News.Category.'.$randomA),
                $this->getReference('Sandbox.News.Category.'.$randomB)
            );

            $post->setCategories(new ArrayCollection($categories));

            $manager->persist($post);

            $this->setReference('Sandbox.News.Entry-'.$i, $post);

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
        return 11;
    }
}
