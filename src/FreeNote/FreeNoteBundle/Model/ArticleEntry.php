<?php

namespace FreeNote\FreeNoteBundle\Model;

use Doctrine\Common\Collections\Collection;
use Sylius\Bundle\BloggerBundle\Entity\Post as BasePost;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Categorized article entry.
 */
class ArticleEntry extends BasePost implements fnUploadableImageInterface
{
    /**
     * @var Collection
     */
    protected $categories;

    /**
     * Image upload.
     *
     * @var UploadedFile
     */
    protected $mainImage;

    /**
     * @var string
     */
    protected $mainImageFilename;

    /**
     * @var string
     */
    protected $mainImagePath;

    /**
     * @var string
     */
    protected $mainImageAbsolutePath;

    /**
     * @var string
     */
    protected $mainImageMimeType;

    /**
     * @var decimal
     */
    protected $mainImageSize;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var string
     */
    protected $updatedBy;

    /**
     * @var string
     */
    protected $publishedBy;


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

    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
    }

    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImageFilename
     */
    public function setMainImageFilename($mainImageFilename)
    {
        $this->mainImageFilename = $mainImageFilename;
    }

    /**
     * @return string
     */
    public function getMainImageFilename()
    {
        return $this->mainImageFilename;
    }

    /**
     * @param string $mainImageAbsolutePath
     */
    public function setMainImageAbsolutePath($mainImageAbsolutePath)
    {
        $this->mainImageAbsolutePath = $mainImageAbsolutePath;
    }

    /**
     * @return string
     */
    public function getMainImageAbsolutePath()
    {
        return $this->mainImageAbsolutePath;
    }

    /**
     * @param string $mainImageMimeType
     */
    public function setMainImageMimeType($mainImageMimeType)
    {
        $this->mainImageMimeType = $mainImageMimeType;
    }

    /**
     * @return string
     */
    public function getMainImageMimeType()
    {
        return $this->mainImageMimeType;
    }

    /**
     * @param string $mainImagePath
     */
    public function setMainImagePath($mainImagePath)
    {
        $this->mainImagePath = $mainImagePath;
    }

    /**
     * @return string
     */
    public function getMainImagePath()
    {
        return $this->mainImagePath;
    }

    /**
     * @param decimal $mainImageSize
     */
    public function setMainImageSize($mainImageSize)
    {
        $this->mainImageSize = $mainImageSize;
    }

    /**
     * @return decimal
     */
    public function getMainImageSize()
    {
        return $this->mainImageSize;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param string $publishedBy
     */
    public function setPublishedBy($publishedBy)
    {
        $this->publishedBy = $publishedBy;
    }

    /**
     * @return string
     */
    public function getPublishedBy()
    {
        return $this->publishedBy;
    }

    /**
     * @param string $updatedBy
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Get comment thread ID.
     *
     * @return string
     */
    public function getCommentThreadId()
    {
        return 'article_entry_'.$this->getId();
    }

    public function getMainImagePathDir()
    {
        if($this->mainImageAbsolutePath)
        {
            return $this->getMainImageAbsolutePath();
        }
        return $this->getImageUploadRootDir();
    }

    /**
     * Returns file upload dir (relative to web directory.
     *
     * @return string
     */
    public function getImageUploadDir()
    {
        return 'uploads/images/article';
    }

    protected function getImageUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getImageUploadDir();
    }

    public function uploadableCallback(array $info)
    {
        $this->setMainImageFilename($info['fileName']);
    }
}
