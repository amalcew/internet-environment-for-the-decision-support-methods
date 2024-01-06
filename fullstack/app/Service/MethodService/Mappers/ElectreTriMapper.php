<?php

namespace App\Service\MethodService\Mappers;

use App\Models\ElectreTri;
use App\Models\Profile;
use App\Models\Project;
use App\Service\MethodService\Transfers\ElectreTriRequest;
use Filament\Facades\Filament;

class ElectreTriMapper
{
    public function generateDTOfromElectreTriModel(ElectreTri $electreTri)
    {
        $dto = new ElectreTriRequest();
        $dto->lambda = $electreTri->lambda;
        $electreCriteria = $electreTri->electreTriCriteriaSettings()->with('criterion')->orderBy('criterion_id')->get();
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
        $dto->b = $dto->variants;
        $dataset_id = Project::all()->firstWhere("id", $electreTri->project_id)->dataset_id;
        $profiles = Profile::all()
            ->where("electre_tri_id", $electreTri->id)
            ->where("dataset_id", $dataset_id);
        foreach ($profiles as $variant) {
            $obj = new \StdClass;
            $obj->values = [];
            foreach ($variant->values->sortBy('criterion_id') as $value) {
                $obj->values[] = $value->value;
            }
            $dto->profiles[] = $obj;
        }

        return $dto;
    }
}
