<?php

namespace FreeNote\FreeNoteBundle\Model;

use Sylius\Bundle\AddressingBundle\Model\AddressInterface;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UserProfile model class.
 */
class UserProfile
{
    const NEW_USER_NEWSLETTER_SIGNUP = 0;
    const NEW_USER_FREE_NOTES = 10;


    /**
     * User.
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $surname;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $recommendedBy;

    /**
     * @var AddressInterface
     */
    protected $postalAddress;

    /**
     * @var string
     */
    protected $avatarPath;

    /**
     * avatar upload.
     * @var string
     */
    protected $avatar;

    /**
     * @var boolean
     */
    protected $newsletter;

    /**
     * @var integer
     */
    protected $freeNotes;

    /**
     * @var string
     */
    protected $companyName;

    /**
     * @var string
     */
    protected $nip;

    /**
     * @var string
     */
    protected $regon;

    /**
     * @var AddressInterface
     */
    protected $businessAddress;

    public function __construct()
    {
        $this->newsletter = self::NEW_USER_NEWSLETTER_SIGNUP;
        $this->freeNotes = self::NEW_USER_FREE_NOTES;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(UserInterface $user)
    {
        $this->user = $user;
        return $this;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatarPath
     */
    public function setAvatarPath($avatarPath)
    {
        $this->avatarPath = $avatarPath;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvatarPath()
    {
        return $this->avatarPath;
    }

    public function getAbsoluteAvatarPath()
    {
        return null === $this->getAvatarPath() ? null : $this->getAvatarUploadRootDir().'/'.$this->getAvatarPath();
    }

    public function getAvatarWebPath()
    {
        return null === $this->getAvatarPath() ? null : $this->getAvatarUploadDir().'/'.$this->getAvatarPath();
    }

    public function getAvatarUploadDir()
    {
        return 'uploads/images/users/avatars';
    }

    public function hasAvatar()
    {
        return null !== $this->getAvatarPath();
    }

    public function saveAvatar()
    {
        if (null === $this->avatar) {
            return;
        }

        $this->setAvatarPath(uniqid().'.'.$this->avatar->guessExtension());
        $this->avatar->move($this->getAvatarUploadRootDir(), $this->getAvatarPath());
    }

    public function deleteAvatar()
    {
        if ($file = $this->getAbsoluteAvatarPath()) {
            unlink($file);
        }
    }

    protected function getAvatarUploadRootDir()
    {
        return __DIR__.'/../../../../../public/'.$this->getAvatarUploadDir();
    }






    /**
     * @param AddressInterface $businessAddress
     */
    public function setBusinessAddress(AddressInterface $businessAddress)
    {
        $this->businessAddress = $businessAddress;
        return $this;
    }

    /**
     * @return AddressInterface
     */
    public function getBusinessAddress()
    {
        return $this->businessAddress;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param int $freeNotes
     */
    public function setFreeNotes($freeNotes)
    {
        $this->freeNotes = $freeNotes;
        return $this;
    }

    /**
     * @return int
     */
    public function getFreeNotes()
    {
        return $this->freeNotes;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param string $nip
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
        return $this;
    }

    /**
     * @return string
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param AddressInterface $postalAddress
     */
    public function setPostalAddress(AddressInterface $postalAddress)
    {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    /**
     * @return AddressInterface
     */
    public function getPostalAddress()
    {
        return $this->postalAddress;
    }

    /**
     * @param string $recommendedBy
     */
    public function setRecommendedBy($recommendedBy)
    {
        $this->recommendedBy = $recommendedBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecommendedBy()
    {
        return $this->recommendedBy;
    }

    /**
     * @param string $regon
     */
    public function setRegon($regon)
    {
        $this->regon = $regon;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegon()
    {
        return $this->regon;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }


}
