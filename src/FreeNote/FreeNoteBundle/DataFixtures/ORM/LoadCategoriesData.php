<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use FreeNote\FreeNoteBundle\Model\fnCategoryInterface;

/**
 * Default blog categories to play with Sylius sandbox.
 */
class LoadCategoriesData extends DataFixture
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

        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog(fnCategoryInterface::FN_CATEGORY_ARTICLE_SLUG);
        $this->referenceNamespace = 'Sandbox.Article.Category.';

        $c0 = $this->createCategory('Artykuły');
        $c1 = $this->createCategory('Zespoły', $c0);
        $this->createCategory('Początkujące', $c1);
        $this->createCategory('Współpracujące z WN', $c1);
        $c2 = $this->createCategory('Płyty', $c0);
        $c3 = $this->createCategory('Recenzje', $c0);
        $this->createCategory('Koncerty', $c3);
        $this->createCategory('Festiwale', $c3);
        $this->createCategory('Dyskografie', $c3);
        $c4 = $this->createCategory('Literatura', $c0);
        $this->createCategory('Biografie', $c4);


//        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog('events');
//
//        $this->createCategory('Premiery');
//        $this->createCategory('Koncerty');
//        $this->createCategory('Zapowiedzi');
//        $this->createCategory('Recenzje');
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name, $parent = null)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);
        if($parent)
        {
            $category->setParent($parent);
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
        return 9;
    }
}
