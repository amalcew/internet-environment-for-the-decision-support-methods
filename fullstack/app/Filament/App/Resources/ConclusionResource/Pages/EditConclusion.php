<?php

namespace App\Filament\App\Resources\ConclusionResource\Pages;

use App\Filament\App\Resources\ConclusionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditConclusion extends EditRecord
{
    protected static string $resource = ConclusionResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Edit Conclusion');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
