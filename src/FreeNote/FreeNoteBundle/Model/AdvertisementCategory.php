<?php

namespace FreeNote\FreeNoteBundle\Model;

use FreeNote\FreeNoteBundle\Model\ArticleCategory as BaseCategory;

/**
 * Advertisement entry category.
 */
class AdvertisementCategory extends BaseCategory implements fnUploadableImageInterface, fnCategoryInterface
{
    /**
     * Returns file upload dir (relative to web directory).
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/advertisement/category';
    }
}
