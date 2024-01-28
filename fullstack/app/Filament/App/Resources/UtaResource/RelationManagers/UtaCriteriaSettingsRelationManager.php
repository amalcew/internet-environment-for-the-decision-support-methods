<?php

namespace App\Filament\App\Resources\UtaResource\RelationManagers;

use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UtaCriteriaSettingsRelationManager extends RelationManager
{
    protected static string $relationship = 'utaCriteriaSettings';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Criteria Settings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('criterion')
                    ->relationship('criterion')->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->inlineLabel()
                    ])
                    ->label('')
                    ->columns(1)
                    ->disabled(),
                Forms\Components\Select::make('type')
                    ->label(__('Type'))
                    ->required()
                    ->options([
                        'cost' => 'cost',
                        'gain' => 'gain',
                    ]),
                Forms\Components\TextInput::make('linear_segments')
                    ->label(__('Linear segments'))
                    ->numeric()
                    ->default(2)
                    ->minValue(2)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('criterion.name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'cost' => 'danger',
                        'gain' => 'success',
                    }),
                Tables\Columns\TextColumn::make('linear_segments')
                    ->label(__('Linear segments')),
            ])
            ->filters([
                SelectFilter::make('criterion')
                    ->label(__('Criterion'))
                    ->relationship('criterion', 'name', function (Builder $query) {
                        $proj = Filament::getTenant();
                        $dataset = $proj->dataset;
                        return $query->whereBelongsTo($dataset);
                    })
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'cost' => 'cost',
                        'gain' => 'gain',
                    ])
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label(__('Add criteria setting')),
            ])
            ->emptyStateHeading('You haven\'t added any criteria setting yet. Let\'s start!')
            ->emptyStateDescription('Criteria settings are used to define the type of criteria and the number of linear segments.');
    }
}
