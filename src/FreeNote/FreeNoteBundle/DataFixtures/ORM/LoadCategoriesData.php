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
    private $referenceNamespace;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $this->get('sylius_categorizer.manager.category');
        $this->manipulator = $this->get('sylius_categorizer.manipulator.category');

        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog('artykuly');
        $this->referenceNamespace = 'Sandbox.Article.Category.';

        $c1 = $this->createCategory('Zespoły');
        $this->createCategory('Początkujące', $c1);
        $this->createCategory('Współpracujące z WN', $c1);
        $c2 = $this->createCategory('Płyty');
        $c3 = $this->createCategory('Recenzje');
        $this->createCategory('Koncerty', $c3);
        $this->createCategory('Festiwale', $c3);
        $this->createCategory('Dyskografie', $c3);
        $c4 = $this->createCategory('Literatura');
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

        $this->manipulator->create($category);
        $this->setReference($this->referenceNamespace.$name, $category);

        return $category;
    }

    public function getOrder()
    {
        return 9;
    }
}
