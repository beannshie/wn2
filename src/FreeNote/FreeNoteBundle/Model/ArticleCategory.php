<?php

namespace FreeNote\FreeNoteBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\CategorizerBundle\Entity\Category as BaseCategory;

/**
 * Article entry category.
 */
class ArticleCategory extends BaseCategory
{
    /**
     * @var Collection
     */
    protected $entries;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->entries = new ArrayCollection;
    }

    /**
     * Get entries.
     *
     * @return Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set entries.
     *
     * @param Collection $entries
     */
    public function setEntries(Collection $entries)
    {
        $this->entries = $entries;
    }
}
