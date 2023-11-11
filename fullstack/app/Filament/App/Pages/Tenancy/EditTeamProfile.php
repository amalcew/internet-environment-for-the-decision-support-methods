<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Models\Dataset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EditTeamProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Project profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Select::make('dataset_id')
                ->relationship(
                    'dataset',
                    'id',
                    modifyQueryUsing: fn (Builder $query) => $query->whereRelation('datasetUsers', 'user_id', '=', auth()->user()->id)->with('user')
                )
                ->getOptionLabelFromRecordUsing(fn (Dataset $dataset) => "{$dataset->name} - {$dataset->user->email}")
            ]);
    }
}
