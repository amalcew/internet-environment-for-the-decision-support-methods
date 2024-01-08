<?php

namespace App\Filament\App\Resources\ElectreTriResource\Pages;

use App\Filament\App\Resources\ElectreTriResource;
use App\Models\ElectreCriteriaSetting;
use App\Models\ElectreTri;
use App\Models\ElectreTriCriteriaSettings;
use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateElectreTri extends CreateRecord
{
    protected static string $resource = ElectreTriResource::class;
    protected static bool $canCreateAnother = false;
    public function afterCreate() {
        /** @var Project $project */
        $project = Filament::getTenant();
        $criteria = $project->criteria;
        /** @var ElectreTri electreTri */
        $electreTri = $this->getRecord();
        $collection = new Collection();
        foreach ($criteria as $criterion) {
//            TODO: could be done more eloquent way :)
            $electreCriterion = (new ElectreTriCriteriaSettings([
                'electre_tri_id' => $electreTri->id,
                'criterion_id' => $criterion->id,
                'weight' => 1,
                'q' => 0,
                'p' => 0,
                'v' => 0,
                'use_veto' => 0
            ]));
            $collection->add($electreCriterion);
        }
        DB::transaction(function () use ($collection) {
            $collection->each(function ($item) {
                $item->save();
            });
        });
    }

    protected function getRedirectUrl(): string
    {
        return ElectreTriResource::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
