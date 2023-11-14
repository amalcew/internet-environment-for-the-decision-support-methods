<?php

namespace App\Filament\App\Resources\ElectreTriResource\Pages;

use App\Filament\App\Resources\ElectreTriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElectreTri extends EditRecord
{
    protected static string $resource = ElectreTriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
