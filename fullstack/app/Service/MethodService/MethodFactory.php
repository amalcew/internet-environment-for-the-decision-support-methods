<?php

namespace App\Service\MethodService;

use App\Service\MethodService\Helpers\UrlHelper;
use App\Service\MethodService\Resolvers\Electre1sResolver;
use App\Service\MethodService\Resolvers\ElectreTriResolver;
use App\Service\MethodService\Resolvers\UTAResolver;

class MethodFactory
{
    public function createElectre1sResolver(): Electre1sResolver
    {
        return new Electre1sResolver(self::createUrlHelper());
    }

    public function createElectreTriResolver(): ElectreTriResolver
    {
        return new ElectreTriResolver(self::createUrlHelper());
    }

    public function createUTAResolver(): UTAResolver
    {
        return new UTAResolver(self::createUrlHelper());
    }

    public function createUrlHelper(): UrlHelper
    {
        return new UrlHelper();
    }
}
