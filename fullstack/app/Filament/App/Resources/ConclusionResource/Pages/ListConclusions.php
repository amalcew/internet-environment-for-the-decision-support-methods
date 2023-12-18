<?php

namespace App\Filament\App\Resources\ConclusionResource\Pages;

use App\Filament\App\Resources\ConclusionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConclusions extends ListRecords
{
    protected static string $resource = ConclusionResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }
}
