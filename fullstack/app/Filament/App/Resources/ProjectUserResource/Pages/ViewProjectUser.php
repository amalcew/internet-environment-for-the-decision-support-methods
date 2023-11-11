<?php

namespace App\Filament\App\Resources\ProjectUserResource\Pages;

use App\Filament\App\Resources\ProjectUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProjectUser extends ViewRecord
{
    protected static string $resource = ProjectUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
