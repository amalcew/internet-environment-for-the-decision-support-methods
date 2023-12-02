<?php

namespace App\Service\MethodService\Helpers;

class UrlHelper
{
    public const ELECTRE_1S_RELATIVE_URL = '/electre1s';
    public const ELECTRE_TRI_RELATIVE_URL = '/electretri';
    public const UTA_RELATIVE_URL = '/UTA';

    public function getBaseUrl()
    {
        $port = env('SPRING_PORT', 8000);
        return "host.docker.internal:$port";
    }
}
