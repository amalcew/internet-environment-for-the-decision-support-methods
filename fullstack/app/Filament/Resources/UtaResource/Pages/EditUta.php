<?php

namespace App\Filament\Resources\UtaResource\Pages;

use App\Filament\Resources\UtaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUta extends EditRecord
{
    protected static string $resource = UtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
