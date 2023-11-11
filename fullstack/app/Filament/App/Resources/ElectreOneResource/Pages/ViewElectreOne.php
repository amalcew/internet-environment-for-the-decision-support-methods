<?php

namespace App\Filament\App\Resources\ElectreOneResource\Pages;

use App\Filament\App\Resources\ElectreOneResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

/**
 * Not sure if still is used, when we have infolist
 */
class ViewElectreOne extends ViewRecord
{
    protected static string $resource = ElectreOneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
