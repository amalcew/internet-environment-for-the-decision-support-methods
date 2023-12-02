<?php

namespace App\Service\MethodService\Helpers;

class UrlHelper
{
    public const ELECTRE_1S_RELATIVE_URL = '/electre1s';

    public function getBaseUrl()
    {
        $port = env('SPRING_PORT', 8000);
        return "host.docker.internal:$port";
    }
}
