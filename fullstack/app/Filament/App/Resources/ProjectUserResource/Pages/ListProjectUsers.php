<?php

namespace App\Filament\App\Resources\ProjectUserResource\Pages;

use App\Filament\App\Resources\ProjectUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListProjectUsers extends ListRecords
{
    protected static string $resource = ProjectUserResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Project sharing');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label(__('Share with user')),
        ];
    }
}
