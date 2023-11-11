<?php

namespace App\Filament\App\Resources\ElectreTriResource\Pages;

use App\Filament\App\Resources\ElectreTriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElectreTris extends ListRecords
{
    protected static string $resource = ElectreTriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
