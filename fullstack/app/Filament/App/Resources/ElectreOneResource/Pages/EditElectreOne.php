<?php

namespace App\Filament\App\Resources\ElectreOneResource\Pages;

use App\Filament\App\Resources\ElectreOneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditElectreOne extends EditRecord
{
    protected static string $resource = ElectreOneResource::class;

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return __('Edit Electre 1s');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
