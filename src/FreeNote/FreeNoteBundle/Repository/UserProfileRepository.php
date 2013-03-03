<?php

namespace FreeNote\FreeNoteBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * User profile entity repository.
 */
class UserProfileRepository extends EntityRepository
{
    public function createNew()
    {
        $className = $this->getClassName();

        return new $className;
    }
}
