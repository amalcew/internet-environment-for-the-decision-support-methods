<?php

namespace App\Filament\App\Resources\ElectreTriResource\Pages;

use App\Filament\App\Resources\ElectreTriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewElectreTri extends ViewRecord
{
    protected static string $resource = ElectreTriResource::class;

    protected ?string $maxContentWidth = 'full';
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function getTitle(): string|Htmlable
    {
        return 'Electre Tri - ' . $this->getRecord()->tag;
    }
}
