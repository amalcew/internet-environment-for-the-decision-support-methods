<?php

namespace App\Filament\App\Resources\ProjectUserResource\Pages;

use App\Filament\App\Resources\ProjectUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProjectUser extends CreateRecord
{
    protected static string $resource = ProjectUserResource::class;
    protected static bool $canCreateAnother = false;

}
