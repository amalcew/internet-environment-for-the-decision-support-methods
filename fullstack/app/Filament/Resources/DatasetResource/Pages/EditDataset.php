<?php

namespace App\Filament\Resources\DatasetResource\Pages;

use App\Filament\Resources\DatasetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditDataset extends EditRecord
{
    protected static string $resource = DatasetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Edit Dataset');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
