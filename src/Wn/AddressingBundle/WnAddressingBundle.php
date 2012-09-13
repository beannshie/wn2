<?php

namespace Wn\AddressingBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnAddressingBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxAddressingBundle';
    }
}
