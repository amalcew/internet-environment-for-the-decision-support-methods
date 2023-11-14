<?php

namespace App\Filament\App\Resources\ElectreTriResource\Pages;

use App\Filament\App\Resources\ElectreTriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewElectreTri extends ViewRecord
{
    protected static string $resource = ElectreTriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
