<?php

namespace App\Service\MethodService\Mappers;

use App\Models\ElectreOne;
use App\Service\MethodService\Transfers\Electre1sRequestDTO;
use Filament\Facades\Filament;

class Electre1sMapper
{
    public function generateDTOfromElectre1sModel(ElectreOne $electreOne)
    {
        $dto = new Electre1sRequestDTO();
        $dto->lambda = $electreOne->lambda;
        $electreCriteria = $electreOne->electreCriteriaSettings()->with('criterion')->orderBy('criterion_id')->get();
        $dto->criteria = $electreCriteria->toArray();
        foreach ($electreCriteria as $i => $electreCriterion) {
            $dto->criteria[$i]['preferenceType'] = $electreCriterion->criterion->type;
        }
        $variants = Filament::getTenant()->variants()->with('values')->get();
        foreach ($variants as $variant) {
            $obj = new \StdClass;
            $obj->values = [];
            foreach ($variant->values->sortBy('criterion_id') as $value) {
                $obj->values[] = $value->value;
            }
            $dto->variants[] = $obj;
        }
        return $dto;
    }

}
