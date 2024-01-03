<?php

namespace App\Filament\App\Resources\ElectreOneResource\Pages;

use App\Filament\App\Resources\ElectreOneResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Not sure if still is used, when we have infolist
 */
class ViewElectreOne extends ViewRecord
{
    protected static string $resource = ElectreOneResource::class;

    protected ?string $maxContentWidth = 'full';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return 'Electre One ' . $this->getRecord()->tag;
    }
}
