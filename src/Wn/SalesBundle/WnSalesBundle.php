<?php

namespace Wn\SalesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnSalesBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxSalesBundle';
    }
}
