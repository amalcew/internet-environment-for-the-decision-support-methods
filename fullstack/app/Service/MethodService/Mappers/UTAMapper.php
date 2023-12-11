<?php

namespace App\Service\MethodService\Mappers;

use App\Models\ElectreTri;
use App\Models\Uta;
use App\Service\MethodService\Transfers\ElectreTriRequest;
use App\Service\MethodService\Transfers\UTARequest;
use Filament\Facades\Filament;

class UTAMapper
{
    public function generateDTOfromUTAModel(Uta $uta)
    {
        $dto = new UTARequest();
        $variants = Filament::getTenant()->variants()->with('values')->get();
        foreach ($variants as $variant) {
            $obj = new \StdClass;
            $obj->values = [];
            foreach ($variant->values->sortBy('criterion_id') as $value) {
                $obj->values[] = $value->value;
            }
            $dto->variants[] = $obj;
        }
        $dto->b = $dto->variants;
        return $dto;
    }
}
