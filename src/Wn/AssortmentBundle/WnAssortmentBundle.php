<?php

namespace Wn\AssortmentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnAssortmentBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxAssortmentBundle';
    }
}
