<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default blog categories to play with Sylius sandbox.
 */
class LoadCategoriesData extends DataFixture
{
    private $manager;
    private $manipulator;
    private $catalog;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $this->get('sylius_categorizer.manager.category');
        $this->manipulator = $this->get('sylius_categorizer.manipulator.category');
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog('artykuly');

        $this->createArticleCategory('Zespoły');
        $this->createArticleCategory('Płyty');
        $this->createArticleCategory('Recenzje');
        $this->createArticleCategory('Literatura');


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
    private function createArticleCategory($name)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);

        $this->manipulator->create($category);
        $this->setReference('Sandbox.Article.Category.'.$name, $category);
    }

    public function getOrder()
    {
        return 9;
    }
}
