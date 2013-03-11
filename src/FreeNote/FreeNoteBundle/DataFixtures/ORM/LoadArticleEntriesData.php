<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default blog posts to play with Sylius sandbox.
 */
class LoadArticleEntriesData extends DataFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $categoriesA = array('Zespoły', 'Płyty');
        $categoriesB = array('Recenzje', 'Literatura');

        for ($i = 1; $i <= 50; $i++) {
            $post = $this->get('free_note.repository.article_entry')->createNew();

            $post->setTitle($this->faker->sentence);
            $post->setAuthor($this->faker->name);
            $post->setContent($this->faker->paragraph(9));

            $randomA = $this->faker->randomElement($categoriesA);
            $randomB = $this->faker->randomElement($categoriesB);

            $categories = array(
                $this->getReference('Sandbox.Article.Category.'.$randomA),
                $this->getReference('Sandbox.Article.Category.'.$randomB)
            );

            $post->setCategories(new ArrayCollection($categories));

            $manager->persist($post);

            $this->setReference('Sandbox.Article.Enrty-'.$i, $post);

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
        return 10;
    }
}
