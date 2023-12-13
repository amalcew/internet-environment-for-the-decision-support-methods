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
class UtaCriteriaSettingsRelationManager extends RelationManager
{
    protected static string $relationship = 'utaCriteriaSettings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // TODO: display edited criterion name, not select list of criteria
                Forms\Components\Select::make('criterion_id')
                    ->options(function(Get $get) {
                        /** @var Project $project */
                        $project = Filament::getTenant();
                        return $project->criteria->pluck('name', 'id');
                    })
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'cost' => 'cost',
                        'gain' => 'gain',
                    ]),
                Forms\Components\TextInput::make('linear_segments')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('criterion.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'cost' => 'danger',
                        'gain' => 'success',
                    }),
                Tables\Columns\TextColumn::make('linear_segments'),
            ])
            ->filters([
                SelectFilter::make('criterion')
                    ->relationship('criterion', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->options([
                        'cost' => 'cost',
                        'gain' => 'gain',
                    ])
                    ->searchable()
                    ->preload()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()->label('Add criteria setting'),
            ])
            ->emptyStateHeading('You haven\'t added any criteria setting yet. Let\'s start!')
            ->emptyStateDescription('Criteria settings are used to define the type of criteria and the number of linear segments.');
    }
}
