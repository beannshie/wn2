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

        // Artykuly
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

        // Aktualnosci
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog(fnCategoryInterface::FN_CATEGORY_NEWS_SLUG);
        $this->referenceNamespace = 'Sandbox.News.Category.';

        $c0 = $this->createCategory('Aktualności');
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

        // Wydarzenia
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog(fnCategoryInterface::FN_CATEGORY_EVENT_SLUG);
        $this->referenceNamespace = 'Sandbox.Event.Category.';

        $c0 = $this->createCategory('Wydarzenia');
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

        // Ogłoszenia
        $this->catalog = $this->get('sylius_categorizer.registry')->getCatalog(fnCategoryInterface::FN_CATEGORY_ADVERTISEMENT_SLUG);
        $this->referenceNamespace = 'Sandbox.Advertisement.Category.';

        $c0 = $this->createCategory('Ogloszenia');
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
    }

    /**
     * Create and save category.
     *
     * @param string $name
     */
    private function createCategory($name, $ancestor = null)
    {
        $category = $this->manager->createCategory($this->catalog);
        $category->setName($name);
        if($ancestor)
        {
            $category->setAncestor($ancestor);
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
