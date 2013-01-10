<?php

/*
 * This file is part of the Sylius sandbox application.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Sandbox\Bundle\BloggerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Sandbox blogger bundle.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SandboxBloggerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SyliusBloggerBundle';
    }
}
