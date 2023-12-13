<?php

namespace App\Filament\Resources\UtaResource\Pages;

use App\Filament\Resources\UtaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUtas extends ListRecords
{
    protected static string $resource = UtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
