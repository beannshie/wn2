<?php

namespace FreeNote\FreeNoteBundle\Model;

use FreeNote\FreeNoteBundle\Model\ArticleCategory as BaseCategory;

/**
 * Event entry category.
 */
class EventCategory extends BaseCategory implements fnUploadableImageInterface, fnCategoryInterface
{
    /**
     * Returns file upload dir (relative to web directory).
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/event/category';
    }
}
