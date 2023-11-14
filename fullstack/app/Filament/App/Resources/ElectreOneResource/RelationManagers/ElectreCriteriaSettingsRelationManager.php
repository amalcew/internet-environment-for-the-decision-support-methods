<?php

namespace App\Filament\App\Resources\ElectreOneResource\RelationManagers;

use App\Models\Criterion;
use App\Models\ElectreOne;
use App\Models\Project;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class ElectreCriteriaSettingsRelationManager extends RelationManager
{
    protected static string $relationship = 'electreCriteriaSettings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('criterion_id')
                    ->options(function(Get $get) {
                        /** @var Project $project */
                        $project = Filament::getTenant();
//                        /** @var ElectreOne $electreOne */
//                        $electreOne = $this->getOwnerRecord();
//                        TODO: try to filter not in electreOne->electreCriteriaSettings
                        return $project->criteria->pluck('name', 'id');
                    })
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('weight')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('q')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('p')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('v')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('criterion.name'),
                Tables\Columns\TextColumn::make('weight'),
                Tables\Columns\TextColumn::make('q'),
                Tables\Columns\TextColumn::make('p'),
                Tables\Columns\TextColumn::make('v'),
            ])
            ->filters([
                //
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
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
