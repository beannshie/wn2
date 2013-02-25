<?php

namespace FreeNote\FreeNoteBundle\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\BloggerBundle\Entity\Post as BasePost;

/**
 * Categorized blog post.
 */
class Post extends BasePost
{
    /**
     * @var Collection
     */
    protected $categories;

    /**
     * Get categories.
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set categories.
     *
     * @param Collection $categories
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'blogger_post_'.$this->getId();
    }
}
