<?php

namespace FreeNote\FreeNoteBundle\Model;

use FreeNote\FreeNoteBundle\Model\ArticleEntry as BasePost;

/**
 * Categorized advertisement entry.
 */
class AdvertisementEntry extends BasePost implements fnUploadableImageInterface
{
    /**
     * @var string
     */
    protected $city;

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'advertisement_entry_'.$this->getId();
    }

    /**
     * Returns file upload dir (relative to web directory).
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/advertisement';
    }
}
