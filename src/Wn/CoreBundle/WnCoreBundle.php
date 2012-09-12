<?php

namespace Wn\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnCoreBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxCoreBundle';
    }
}
