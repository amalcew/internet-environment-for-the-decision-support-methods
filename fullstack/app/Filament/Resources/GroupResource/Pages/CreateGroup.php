<?php

namespace App\Filament\Resources\GroupResource\Pages;

use App\Filament\Resources\GroupResource;
use App\Models\Group;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateGroup extends CreateRecord
{
    protected static string $resource = GroupResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Create Group');
    }


    protected function handleRecordCreation(array $data): Model
    {
        /** @var Group $record */
        $record = new ($this->getModel())($data);
        $record->user_id = auth()->id();
        $record->save();

        return $record;
    }
}
