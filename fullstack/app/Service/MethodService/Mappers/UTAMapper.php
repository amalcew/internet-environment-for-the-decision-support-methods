<?php

namespace App\Service\MethodService\Mappers;

use App\Models\ElectreTri;
use App\Models\Uta;
use App\Service\MethodService\Transfers\ElectreTriRequest;
use App\Service\MethodService\Transfers\UTARequest;
use Filament\Facades\Filament;

class UTAMapper
{
    public function generateDTOfromUTAModel(Uta $uta, $alternativesPreferences)
    {
        $dto = new UTARequest();
        $dto->epsilon = $uta->epsilon;
        $utaCriteria = $uta->utaCriteriaSettings()->with('criterion')->orderBy('criterion_id')->get();
        $types = [];
        $breakPoints = [];
        foreach ($utaCriteria as $criteria) {
            if ($criteria->type == 'cost') $type = 'min';
            else $type = 'max';
            $types[] = $type;
            $breakPoints[] = $criteria->linear_segments;
        }
        $dto->criteriaMinMax = $types;
        $dto->criteriaNumberOfBreakPoints = $breakPoints;

        $variantNames = [];
        $criteriaNames = [];

        $criteria = Filament::getTenant()->criteria()->get();
        foreach ($criteria as $criterion) {
            $criteriaNames[] = $criterion->name;
        }
        $variantValues = [];
        $variants = Filament::getTenant()->variants()->with('values')->get();
        foreach ($variants as $variant) {
            $values = [];
            foreach ($variant->values->sortBy('criterion_id') as $value) {
                $values[] = $value->value;

            }
            $variantValues[] = $values;
            $variantNames[] = $variant->name;
        }

        $dto->performanceTable = $variantValues;
        $dto->rownamesPerformanceTable = $variantNames;
        $dto->alternativesPreferences = $alternativesPreferences;
        $dto->alternativesIndifferences = null;
        $dto->colnamesPerformanceTable = $criteriaNames;
        $dto->alternativesRanks = null;
      //  dd($dto);
        return $dto;
    }
}
