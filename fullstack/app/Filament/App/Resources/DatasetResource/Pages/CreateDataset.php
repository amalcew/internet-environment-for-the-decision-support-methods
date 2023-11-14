<?php

namespace App\Filament\App\Resources\DatasetResource\Pages;

use App\Events\AfterDatasetCreated;
use App\Filament\App\Resources\DatasetResource;
use App\Models\Dataset;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateDataset extends CreateRecord
{
    protected static string $resource = DatasetResource::class;

//    change tenant filter to user filter
    protected function handleRecordCreation(array $data): Model
    {
        /** @var TemporaryUploadedFile $file */
        $file = $data['csv_file'];
        unset($data['csv_file']);
        /** @var Dataset $record */
        $record = new ($this->getModel())($data);
        $record->user()->associate(auth()->user());
        $record->save();
        $record->members()->attach(auth()->user()); // populate dataset_user too
        $record->save();
        AfterDatasetCreated::dispatch($record, $file);
        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return Filament::getUrl() . '/profile';
    }
}
