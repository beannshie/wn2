<?php

namespace Wn\CartBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnCartBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxCartBundle';
    }
}
