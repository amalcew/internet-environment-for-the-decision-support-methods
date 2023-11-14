<?php

namespace App\Filament\App\Resources\UtaResource\Pages;

use App\Filament\App\Resources\UtaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUta extends EditRecord
{
    protected static string $resource = UtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
