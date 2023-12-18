<?php

namespace App\Filament\App\Resources\UtaResource\Pages;

use App\Filament\App\Resources\UtaResource;
use App\Models\Project;
use App\Models\UtaCriteriaSetting;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CreateUta extends CreateRecord
{
    protected static string $resource = UtaResource::class;

    public const TYPE_COST = 'cost';
    public const TYPE_GAIN = 'gain';

    public function afterCreate()
    {
        /** @var Project $project */
        $project = Filament::getTenant();
        $criteria = $project->criteria;
        /** @var Uta $uta */
        $uta = $this->getRecord();
        $collection = new Collection();
        foreach ($criteria as $criterion) {
            $utaCriterion = (new UtaCriteriaSetting([
                'uta_id' => $uta->id,
                'criterion_id' => $criterion->id,
                'type' => 'cost',
                'linear_segments' => 2
            ]));
            $collection->add($utaCriterion);
        }
        DB::transaction(function () use ($collection) {
            $collection->each(function ($item) {
                $item->save();
            });
        });

    }

    protected function getRedirectUrl(): string
    {
        return UtaResource::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
