<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Project;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterTeam extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register your project';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
            ]);
    }

    protected function handleRegistration(array $data): Project
    {
        $data['user_id'] = auth()->user()->id;
        $project = Project::create($data);

        $project->directMembers()->attach(auth()->user());
        return $project;
    }
}
