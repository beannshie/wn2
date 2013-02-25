<?php

namespace FreeNote\FreeNoteBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\CategorizerBundle\Entity\Category as BaseCategory;

/**
 * Blog post category.
 */
class PostCategory extends BaseCategory
{
    /**
     * @var Collection
     */
    protected $posts;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->posts = new ArrayCollection;
    }

    /**
     * Get posts.
     *
     * @return Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set posts.
     *
     * @param Collection $posts
     */
    public function setPosts(Collection $posts)
    {
        $this->posts = $posts;
    }
}
