<?php

namespace FreeNote\FreeNoteBundle\Model;

use FreeNote\FreeNoteBundle\Model\ArticleEntry as BasePost;

/**
 * Categorized event entry.
 */
class EventEntry extends BasePost implements fnUploadableImageInterface
{
    /**
     * @var string
     */
    protected $place;

    /**
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'event_entry_'.$this->getId();
    }

    /**
     * Returns file upload dir (relative to web directory).
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/event';
    }
}
