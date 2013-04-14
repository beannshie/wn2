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
    protected $image;

    /**
     * @var string
     */
    protected $imageFilename;

    /**
     * @var string
     */
    protected $imagePath;

    /**
     * @var string
     */
    protected $imageAbsolutePath;

    /**
     * @var string
     */
    protected $imageMimeType;

    /**
     * @var decimal
     */
    protected $imageSize;

    /**
     * @var string
     */
    protected $imageAlt;

    /**
     * @var string
     */
    protected $imageTitle;

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

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $imageFilename
     */
    public function setImageFilename($imageFilename)
    {
        $this->imageFilename = $imageFilename;
    }

    /**
     * @return string
     */
    public function getImageFilename()
    {
        return $this->imageFilename;
    }

    /**
     * @param string $imageAbsolutePath
     */
    public function setImageAbsolutePath($imageAbsolutePath)
    {
        $this->imageAbsolutePath = $imageAbsolutePath;
    }

    /**
     * @return string
     */
    public function getImageAbsolutePath()
    {
        return $this->imageAbsolutePath;
    }

    /**
     * @param string $imageMimeType
     */
    public function setImageMimeType($imageMimeType)
    {
        $this->imageMimeType = $imageMimeType;
    }

    /**
     * @return string
     */
    public function getImageMimeType()
    {
        return $this->imageMimeType;
    }

    /**
     * @param string $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param decimal $imageSize
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;
    }

    /**
     * @return decimal
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * @param string $imageAlt
     */
    public function setImageAlt($imageAlt)
    {
        $this->imageAlt = $imageAlt;
    }

    /**
     * @return string
     */
    public function getImageAlt()
    {
        return $this->imageAlt;
    }

    /**
     * @param string $imageTitle
     */
    public function setImageTitle($imageTitle)
    {
        $this->imageTitle = $imageTitle;
    }

    /**
     * @return string
     */
    public function getImageTitle()
    {
        return $this->imageTitle;
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

    public function getImagePathDir()
    {
        if($this->imageAbsolutePath)
        {
            return $this->getImageAbsolutePath();
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
        $this->setImageFilename($info['fileName']);
    }

    public function getImageWebPath()
    {
        return $this->getImageFilename() ? $this->getImageUploadDir().DIRECTORY_SEPARATOR.$this->getImageFilename() : null;
    }

    public function saveTitleAlt()
    {
        if($this->imageFilename)
        {
            if(empty($this->imageTitle))
            {
                $this->imageTitle = ucfirst($this->title);
            }
            if(empty($this->imageAlt))
            {
                $this->imageAlt = $this->title;
            }
        }
    }
}
