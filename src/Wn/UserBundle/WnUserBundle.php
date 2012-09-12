<?php

namespace Wn\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnUserBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxUserBundle';
    }
}
