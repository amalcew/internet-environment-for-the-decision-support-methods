<?php

namespace App\Filament\App\Resources\DatasetResource\Pages;

use App\Events\AfterDatasetCreated;
use App\Filament\App\Resources\DatasetResource;
use App\Models\Dataset;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateDataset extends CreateRecord
{
    protected static string $resource = DatasetResource::class;
    protected static bool $canCreateAnother = false;

    public function getTitle(): string|Htmlable
    {
        return __('Create Dataset');
    }


//    change tenant filter to user filter
    protected function handleRecordCreation(array $data): Model
    {
        /** @var TemporaryUploadedFile $file */
        $file = $data['csv_file'];
        unset($data['csv_file']);
        /** @var Dataset $record */
        $record = new ($this->getModel())($data);
        DB::transaction(function () use ($record, $file) {
            $record->user()->associate(auth()->user());
            $saved = $record->save();
            if ($saved) {
                $record->directMembers()->attach(auth()->user()); // populate dataset_user too
                $record->save();
                AfterDatasetCreated::dispatch($record, $file);
            }
        });

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return Filament::getTenantProfileUrl();
    }
}
