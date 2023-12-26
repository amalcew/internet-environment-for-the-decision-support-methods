<?php

namespace App\Filament\App\Resources\ConclusionResource\Pages;

use App\Filament\App\Resources\ConclusionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateConclusion extends CreateRecord
{
    protected static string $resource = ConclusionResource::class;

    protected static bool $canCreateAnother = false;
}
