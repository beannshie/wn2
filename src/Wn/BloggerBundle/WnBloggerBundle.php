<?php

namespace Wn\BloggerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnBloggerBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxBloggerBundle';
    }
}
