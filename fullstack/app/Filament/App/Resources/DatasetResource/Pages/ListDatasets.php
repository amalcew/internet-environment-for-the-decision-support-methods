<?php

namespace App\Filament\App\Resources\DatasetResource\Pages;

use App\Filament\App\Resources\DatasetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListDatasets extends ListRecords
{
    protected static string $resource = DatasetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Datasets');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
