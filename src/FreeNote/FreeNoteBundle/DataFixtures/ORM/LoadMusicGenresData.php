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
        $c1 = $this->createCategory('Alternative', 'muzykaAlt', $c0);
        $orig1 = $this->createCategory('Punk Rock', null, $c1);
        $this->createCategory('More Alternative', null, $c1);
        $c2 = $this->createCategory('Lata 80-te', 'muzyka80te', $c0);
        $c3 = $this->createCategory('Acoustic', 'muzykaAcoustic', $c0);
        $this->createCategory('Live Acoustic',null, $c3);
        $this->createCategory('Studio Acoustic', null, $c3);
        $c4 = $this->createCategory('Hard Rock', 'muzykaHardRock', $c0);
        $this->createCategory('Punk Rock', null, $c4, $orig1);
        $c5 = $this->createCategory('Disco', 'muzykaDisco', $c0);
        $this->createCategory('Disco Polo', null, $c5);
        $this->createCategory('Pop', null, $c5);
        $this->createCategory('Disco disco jupikajej', null, $c5);
        $c6 = $this->createCategory('Gothic', 'muzykaGothic', $c0);
        $c7 = $this->createCategory('Heavy Metal', 'muzykaHeavyM', $c0);
        $c8 = $this->createCategory('Jazz', 'muzykaJazz', $c0);
        $c9 = $this->createCategory('Lyric', 'muzykaLyric', $c0);
        $this->createCategory('Poezja śpiewana', null, $c9);
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name, $filename = null, $ancestor = null, $origin = null)
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

        $category->setImageFilename(($filename?($filename.'.png'):'t-shirt.jpg'));
        $category->setImagePath('../../bundles/freenote/images/t-shirt.png');
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
