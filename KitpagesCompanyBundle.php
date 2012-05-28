<?php

namespace Kitpages\CompanyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class KitpagesCompanyBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
