<?php

namespace App\Filament\App\Resources\GroupResource\Pages;

use App\Filament\App\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ListGroups extends ListRecords
{
    protected static string $resource = GroupResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Groups');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
