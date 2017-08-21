<?php

namespace Lddt\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LddtUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
