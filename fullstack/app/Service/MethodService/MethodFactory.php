<?php

namespace App\Service\MethodService;

use App\Service\MethodService\Helpers\UrlHelper;
use App\Service\MethodService\Resolvers\Electre1sResolver;

class MethodFactory
{
    public function createElectre1sResolver(): Electre1sResolver
    {
        return new Electre1sResolver(self::createUrlHelper());
    }

    public function createUrlHelper(): UrlHelper
    {
        return new UrlHelper();
    }
}
