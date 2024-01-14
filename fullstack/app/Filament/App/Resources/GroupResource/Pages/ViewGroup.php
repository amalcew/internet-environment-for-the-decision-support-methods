<?php

namespace App\Filament\App\Resources\GroupResource\Pages;

use App\Filament\App\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ViewGroup extends ViewRecord
{
    protected static string $resource = GroupResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('View Group');
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
