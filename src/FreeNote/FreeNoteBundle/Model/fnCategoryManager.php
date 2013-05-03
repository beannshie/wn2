<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\CategorizerBundle\Entity\CategoryManager;
use Sylius\Bundle\CategorizerBundle\Model\CategoryInterface;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;
use Sylius\Bundle\CategorizerBundle\Registry\CatalogRegistry;
use Sylius\Bundle\CategorizerBundle\Registry\CatalogInterface;
use Doctrine\ORM\EntityManager;

class fnCategoryManager extends CategoryManager
{
    /**
     * UploadableManager.
     *
     * @var UploadableManager
     */
    protected $uploadableManager;

    /**
     * Path to web dir.
     *
     * @var string
     */
    protected $fnWebDir;

    /**
     * Constructor.
     *
     * @param CatalogRegistry $catalogRegistry
     * @param EntityManager  $entityManager
     */
    public function __construct(CatalogRegistry $catalogRegistry, EntityManager $entityManager, UploadableManager $uploadableManager, $fnWebDir)
    {
        $this->uploadableManager = $uploadableManager;
        $this->fnWebDir = $fnWebDir;

        parent::__construct($catalogRegistry, $entityManager);
    }

    /**
     * Return main categories in nested tree
     * @param CatalogInterface $catalog
     * @return mixed
     */
    public function findRootCategories(CatalogInterface $catalog)
    {
        $rootCategory = $this->getCatalogCategory($catalog);
        return $this->getRepository($catalog)->getChildren($rootCategory, true);
    }

    public function findChildren(CatalogInterface $catalog)
    {
        return $this->getRepository($catalog)->getChildren();
    }

    public function findChildrenHierarchyCollection(CatalogInterface $catalog)
    {
        $rootCategory = $this->getCatalogCategory($catalog);
        return $this->getRepository($catalog)->getNodesHierarchyCollection($rootCategory);
    }

    public function persistCategory(CategoryInterface $category)
    {
        $this->entityManager->persist($category);
        $this->refreshCategoryPosition($category);

        //for doctrine uploadable extension
        if($category->getImage())
        {
            // change saved to database path to image
            if($category instanceof fnUploadableImageInterface)
            {
                $category->setImageAbsolutePath($this->fnWebDir.DIRECTORY_SEPARATOR.$category->getImageUploadDir());
            }

            // Here, "getImage" returns the "UploadedFile" instance that the form bound in your $image property
            $this->uploadableManager->markEntityToUpload($category, $category->getImage());
        }

        $this->entityManager->flush();
    }

    public function moveCategoryUp(CategoryInterface $category)
    {
        $repository = $this->getRepository($this->catalogRegistry->guessCatalog($category));
        if ($this->isNested($category)) {
            if(!$category->isRoot())
            {
                $repository->moveUp($category, 1);
                $this->entityManager->clear();
            }
        } else {
            if (!$relatedCategory = $repository->findOneBy(array('position' => $category->getPosition() - 1))) {

                throw new \LogicException('Cannot move up top category.');
            }
            $this->swapCategoriesPosition($category, $relatedCategory);
        }
    }

    private function getCatalogCategory(CatalogInterface $catalog)
    {
        if (!$rootCategory = $this->getRepository($catalog)->findOneBySlug($catalog->getAlias()))
        {
            throw new \InvalidArgumentException('Requested category catalog does not exist: '.$catalog->getAlias().'.');
        }
        return $rootCategory;
    }

    public function generateChoices($catalog)
    {
        if($catalog == fnCategoryInterface::FN_MUSIC_GENRE_ORIGIN_SLUG)
        {
            return $this->generateMusicGenreOriginChoices(fnCategoryInterface::FN_MUSIC_GENRE_SLUG);
        }
        else
        {
            return parent::generateChoices($catalog);
        }
    }

    public function generateMusicGenreOriginChoices($catalog)
    {
        $queryBuilder = $this->getRepository($catalog)->createQueryBuilder('c');

        $queryBuilder
            ->where('c.is_fake = :fake')
            ->setParameter('fake', 0)
            ->andWhere('c.slug != :catalogslug')
            ->setParameter('catalogslug', $catalog)
            ->orderBy('c.left');

        return $queryBuilder->getQuery()->execute();
    }
}
