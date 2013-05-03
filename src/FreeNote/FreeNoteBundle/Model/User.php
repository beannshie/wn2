<?php

namespace FreeNote\FreeNoteBundle\Model;

use FOS\UserBundle\Entity\User as BaseUser;
use FreeNote\FreeNoteBundle\Entity\UserProfile as UserProfileEntity;

/**
 * User entity.
 */
class User extends BaseUser implements fnUserInterface
{
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
