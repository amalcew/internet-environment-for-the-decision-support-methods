<?php

namespace App\Filament\App\Resources\UtaResource\Pages;

use App\Filament\App\Resources\UtaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUta extends ViewRecord
{
    protected static string $resource = UtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
