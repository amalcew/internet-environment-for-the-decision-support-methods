<?php

namespace App\Filament\App\Resources\ConclusionResource\Pages;

use App\Filament\App\Resources\ConclusionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListConclusions extends ListRecords
{
    protected static string $resource = ConclusionResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Conclusions');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }
}
