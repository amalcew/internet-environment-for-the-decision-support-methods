<?php

namespace App\Filament\App\Resources\ElectreOneResource\Pages;

use App\Filament\App\Resources\ElectreOneResource;
use App\Models\ElectreCriteriaSetting;
use App\Models\ElectreOne;
use App\Models\Project;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateElectreOne extends CreateRecord
{
    protected static string $resource = ElectreOneResource::class;

    public function afterCreate() {
        /** @var Project $project */
        $project = Filament::getTenant();
        $criteria = $project->criteria;
        /** @var ElectreOne $electreOne */
        $electreOne = $this->getRecord();
        $collection = new Collection();
        foreach ($criteria as $criterion) {
//            TODO: could be done more eloquent way :)
            $electreCriterion = (new ElectreCriteriaSetting([
                'electre_one_id' => $electreOne->id,
                'criterion_id' => $criterion->id,
                'weight' => 1,
                'q' => 0,
                'p' => 0,
                'v' => 0,
            ]));
            $collection->add($electreCriterion);
        }
        DB::transaction (function () use ($collection) {
            $collection->each(function ($item) {
                $item->save();
            });
        });

    }
    protected function getRedirectUrl(): string
    {
        return ElectreOneResource::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
