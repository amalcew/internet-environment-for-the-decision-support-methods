<?php

namespace App\Filament\App\Pages\Tenancy;

use App\Filament\App\Resources\DatasetResource\Helper\QueryHelper;
use App\Models\Dataset;
use Filament\Facades\Filament;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Dashboard;
use Filament\Pages\Tenancy\EditTenantProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EditTeamProfile extends EditTenantProfile
{
//    This is not a resource. Policies doesn't work there!
    public static function getLabel(): string
    {
        return 'Project profile';
    }
    protected function getFormActions(): array
    {
        $proj = Filament::getTenant();
        if ($proj->user_id != auth()->id()) {
            return [];
        }
        return parent::getFormActions();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                Select::make('dataset_id')
                    ->disabled(fn($state) => filled($state))
                    ->relationship(
                        'dataset',
                        'id',
//                        TODO: oft
                        modifyQueryUsing: fn(Builder $query) => QueryHelper::adjustQueryForDatasetAccess($query)->with('user')
                    )
                    ->getOptionLabelFromRecordUsing(fn(Dataset $dataset) => "{$dataset->name} - {$dataset->user->email}"),
                Placeholder::make('info')
                ->content('If you already selected a dataset, you need a new project to use another dataset.')
            ]);
    }
}
