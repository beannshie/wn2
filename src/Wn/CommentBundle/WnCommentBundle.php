<?php

namespace Wn\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class WnCommentBundle extends Bundle
{
    public function getParent()
    {
        return 'SandboxCommentBundle';
    }
}
