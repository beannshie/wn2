<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kaala
 * Date: 9/9/12
 * Time: 8:08 PM
 * To change this template use File | Settings | File Templates.
 */

// src/Wn/UserBundle/Entity/WnUser.php

namespace Wn\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class WnUser extends \Sylius\Sandbox\Bundle\UserBundle\Entity\User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
