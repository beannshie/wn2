<?php

namespace FreeNote\FreeNoteBundle\Model;

use FreeNote\FreeNoteBundle\Model\ArticleCategory as BaseCategory;
use Sylius\Bundle\CategorizerBundle\Model\NestedCategoryInterface;

/**
 * News entry category.
 */
class NewsCategory extends BaseCategory implements fnUploadableImageInterface, fnCategoryInterface
{
    /**
     * Returns file upload dir (relative to web directory.
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/news/category';
    }
}
