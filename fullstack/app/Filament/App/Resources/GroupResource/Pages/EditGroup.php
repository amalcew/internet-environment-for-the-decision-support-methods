<?php

namespace App\Filament\App\Resources\GroupResource\Pages;

use App\Filament\App\Resources\GroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EditGroup extends EditRecord
{
    protected static string $resource = GroupResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Edit Group');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
