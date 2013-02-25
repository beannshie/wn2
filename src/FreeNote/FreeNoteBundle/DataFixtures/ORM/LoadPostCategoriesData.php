<?php

namespace FreeNote\FreeNoteBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default blog categories to play with Sylius sandbox.
 */
class LoadPostCategoriesData extends DataFixture
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
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog('articles');

        $this->createCategory('Symfony2');
        $this->createCategory('Doctrine');
        $this->createCategory('Sylius');
        $this->createCategory('Composer');


        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog('news');

        $this->createCategory('newsSymfony2');
        $this->createCategory('newsDoctrine');
        $this->createCategory('newsSylius');
        $this->createCategory('newsComposer');
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);

        $this->manipulator->create($category);
        $this->setReference('Sandbox.Blogger.Category.'.$name, $category);
    }

    public function getOrder()
    {
        return 9;
    }
}
