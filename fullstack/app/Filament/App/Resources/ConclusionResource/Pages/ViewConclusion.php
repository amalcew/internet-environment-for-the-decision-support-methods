<?php

namespace App\Filament\App\Resources\ConclusionResource\Pages;

use App\Filament\App\Resources\ConclusionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewConclusion extends ViewRecord
{
    protected static string $resource = ConclusionResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('View Conclusion');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
