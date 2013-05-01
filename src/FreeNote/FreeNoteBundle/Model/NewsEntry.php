<?php

namespace FreeNote\FreeNoteBundle\Model;

use FreeNote\FreeNoteBundle\Model\ArticleEntry as BasePost;

/**
 * Categorized news entry.
 */
class NewsEntry extends BasePost implements fnUploadableImageInterface
{
    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'news_entry_'.$this->getId();
    }

    /**
     * Returns file upload dir (relative to web directory).
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/news';
    }
}
