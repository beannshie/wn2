<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\CategorizerBundle\Entity\CategoryManager;
use Sylius\Bundle\CategorizerBundle\Model\CategoryInterface;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;

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
     * @param CataogRegistry $catalogRegistry
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
     * @param $catalog
     * @return mixed
     */
    public function findRootCategories($catalog)
    {
        return $this->getRepository($catalog)->getChildren(null, true);
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

            // Here, "getMainImage" returns the "UploadedFile" instance that the form bound in your $mainImage property
            $this->uploadableManager->markEntityToUpload($category, $category->getImage());
        }

        $this->entityManager->flush();
    }
}
