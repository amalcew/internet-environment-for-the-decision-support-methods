<?php

namespace App\Filament\App\Resources\ElectreOneResource\Pages;

use App\Filament\App\Resources\ElectreOneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElectreOnes extends ListRecords
{
    protected static string $resource = ElectreOneResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return __('Electre 1s');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
