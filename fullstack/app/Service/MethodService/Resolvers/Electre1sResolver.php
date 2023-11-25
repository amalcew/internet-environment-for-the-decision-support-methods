<?php

namespace App\Service\MethodService\Resolvers;

use App\Service\MethodService\Helpers\UrlHelper;
use App\Service\MethodService\Transfers\Electre1sRequestDTO;
use Illuminate\Support\Facades\Http;

class Electre1sResolver
{
    public function __construct(private readonly UrlHelper $urlHelper)
    {
    }

    public function resolve(Electre1sRequestDTO $dto) {
        $url = $this->urlHelper->getBaseUrl() . UrlHelper::ELECTRE_1S_RELATIVE_URL;
        $response = Http::asJson()->post($url, ['data' => $dto]);
        return json_decode($response->body());
    }
}
