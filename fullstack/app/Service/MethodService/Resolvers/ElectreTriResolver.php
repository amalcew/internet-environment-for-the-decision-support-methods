<?php

namespace App\Service\MethodService\Resolvers;

use App\Service\MethodService\Helpers\UrlHelper;
use App\Service\MethodService\Transfers\ElectreTriRequest;
use Illuminate\Support\Facades\Http;

class ElectreTriResolver
{
    public function __construct(private readonly UrlHelper $urlHelper)
    {
    }

    public function resolve(ElectreTriRequest $dto, $transposeArraysInResults) {
        $url = $this->urlHelper->getBaseUrl() . UrlHelper::ELECTRE_TRI_RELATIVE_URL;
        $response = Http::asJson()->post($url, ['data' => $dto]);
        $data = json_decode($response->body());
        if ($transposeArraysInResults) {
            $data = $this->transposeArraysInData($data);
        }
        return $data;
    }

    public function transposeArraysInData($data) {
        foreach ($data as $key => $value) {
            if (is_array($value) && is_array($value[0])) {
                $data->{$key} = $this->transpose($value);
            }
        }
        return $data;
    }
    private function transpose($array) {
        return array_map(null, ...$array);
    }
}
