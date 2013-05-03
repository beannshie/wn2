<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

/**
 * Default music genres to play with.
 */
class LoadMusicGenresData extends DataFixture
{
    private $manager;
    private $manipulator;
    private $catalog;
    private $referenceNamespace;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $this->get('sylius_categorizer.manager.category');
        $this->manipulator = $this->get('sylius_categorizer.manipulator.category');

        // Music genres
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog(fnCategoryInterface::FN_MUSIC_GENRE_SLUG);
        $this->referenceNamespace = 'Sandbox.Music.Genre.';

        $c0 = $this->createCategory(fnCategoryInterface::FN_MUSIC_GENRE_SLUG);
        $c1 = $this->createCategory('Rock', $c0);
        $orig1 = $this->createCategory('Punk Rock', $c1);
        $this->createCategory('Rock', $c1);
        $c2 = $this->createCategory('Techno', $c0);
        $c3 = $this->createCategory('Metal', $c0);
        $this->createCategory('Black Metal', $c3);
        $this->createCategory('Heavy Metal', $c3);
        $this->createCategory('Trash', $c3);
        $c4 = $this->createCategory('Punk', $c0);
        $this->createCategory('Punk Rock', $c4, $orig1);
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name, $ancestor = null, $origin = null)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);
        if($ancestor)
        {
            $category->setAncestor($ancestor);
        }
        if($origin)
        {
            $category->setOrigin($origin);
            $category->setIsFake(true);
        }

        $category->setImageFilename('t-shirt.jpg');
        $category->setImagePath('../../bundles/freenote/images/t-shirt.jpg');
        $category->setImageMimeType('image/jpg');
        $category->setImageSize(123);
        $category->setImageAlt('ikona');
        $category->setImageTitle('Ikona');

        $category->setCreatedBy($this->getReference('User-'.rand(1, 15)));
        $category->setUpdatedBy($this->faker->userName);

        $this->manipulator->create($category);
        $this->setReference($this->referenceNamespace.$name, $category);

        return $category;
    }

    public function getOrder()
    {
        return 14;
    }
}
