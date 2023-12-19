<?php

namespace App\Filament\App\Resources\UtaResource\Pages;

use App\Filament\App\Resources\UtaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUta extends CreateRecord
{
    protected static string $resource = UtaResource::class;
    protected static bool $canCreateAnother = false;

}
