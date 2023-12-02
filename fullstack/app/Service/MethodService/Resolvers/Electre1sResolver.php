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

    public function resolve(Electre1sRequestDTO $dto, $transposeArraysInResults) {
        $url = $this->urlHelper->getBaseUrl() . UrlHelper::ELECTRE_1S_RELATIVE_URL;
        $response = Http::asJson()->post($url, ['data' => $dto]);
        $data = json_decode($response->body());
        if ($transposeArraysInResults) {
            $data = $this->transposeArraysInData($data);
        }
        return $data;
    }

    public function transposeArraysInData($data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data->{$key} = $this->transpose($value);
            }
        }
        return $data;
    }
    private function transpose($array) {
        return array_map(null, ...$array);
    }
}
