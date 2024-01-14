<?php

namespace App\Filament\App\Resources\ProjectUserResource\Pages;

use App\Filament\App\Resources\ProjectUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateProjectUser extends CreateRecord
{
    protected static string $resource = ProjectUserResource::class;
    protected static bool $canCreateAnother = false;

    public function getTitle(): string|Htmlable
    {
        return __('Share Project');
    }

}
