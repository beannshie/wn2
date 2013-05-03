<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\CategorizerBundle\Model\NestedCategoryInterface;
use Symfony\Component\Validator\ExecutionContextInterface;
use FreeNote\FreeNoteBundle\Model\ArticleCategory as BaseCategory;

/**
 * Music genre.
 */
class MusicGenre extends BaseCategory implements fnUploadableImageInterface, fnCategoryInterface
{
    /**
     * Origin category.
     *
     * @var NestedCategoryInterface
     */
    protected $origin;

    /**
     * @var boolean
     */
    protected $is_fake = false;

    /**
     * {@inheritdoc}
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }

    /**
     * @param boolean $is_fake
     */
    public function setIsFake($is_fake)
    {
        $this->is_fake = $is_fake;
    }

    /**
     * @return boolean
     */
    public function getIsFake()
    {
        return $this->is_fake;
    }

    /**
     * Returns file upload dir (relative to web directory).
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/music_genre';
    }

    public function checkFake()
    {
        if($this->origin)
        {
            $this->is_fake = true;
        }
        else
        {
            $this->is_fake = false;
        }
    }

    public function isOriginValid(ExecutionContextInterface $context)
    {
        if($this->getOrigin() && $this->id == $this->getOrigin()->getId())
        {
            $context->addViolationAt('origin', 'Wybrana kategoria nadrzędna jest tożsama z tą, którą edytujesz. Nie można dokonać takiego przypisania!', array(), null);
        }
    }
}
