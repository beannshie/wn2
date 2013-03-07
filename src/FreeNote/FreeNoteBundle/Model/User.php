<?php

namespace FreeNote\FreeNoteBundle\Model;

use FOS\UserBundle\Entity\User as BaseUser;
use FreeNote\FreeNoteBundle\Entity\UserProfile as UserProfileEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User entity.
 */
class User extends BaseUser implements fnUserInterface
{
    /**
     * @Assert\Type(type="FreeNote\FreeNoteBundle\Entity\UserProfile")
     */
    protected $userProfile;

    public function getUserProfile()
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfileEntity $userProfile = null)
    {
        $this->userProfile = $userProfile;
    }
}
