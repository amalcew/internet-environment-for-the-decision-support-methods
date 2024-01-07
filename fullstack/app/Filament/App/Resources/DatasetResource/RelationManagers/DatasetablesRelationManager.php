<?php

namespace App\Filament\App\Resources\DatasetResource\RelationManagers;

use App\Filament\App\Resources\DatasetResource\Helper\QueryHelper;
use App\Models\Dataset;
use App\Models\Group;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DatasetablesRelationManager extends RelationManager
{
    protected static string $relationship = 'datasetables';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('datasetable_type')
                    ->options(['App\Models\Group' => 'Group', 'App\Models\User' => 'User'])
                    ->live(),
                Forms\Components\Select::make('datasetable_id')
                    ->options(fn(Get $get) => match ($get('datasetable_type')) {
                        'App\Models\Group' => Group::query()->whereNotExists(
                            function ($query) {
                                $dataset = $this->getOwnerRecord();
                                $query->from('datasetables')
                                    ->where('datasetables.dataset_id', '=', $dataset->id)
                                    ->where('datasetables.datasetable_type', '=', "'App\Models\Group'");
                            })->pluck('name', 'id'),
                        'App\Models\User' => User::query()->whereNotExists(
                            function ($query) {
                                $dataset = $this->getOwnerRecord();
                                $query->from('datasetables')
                                    ->where('datasetables.dataset_id', '=', $dataset->id)
                                    ->where('datasetables.datasetable_type', '=', "'App\Models\User'");
                            })->pluck('name', 'id'),
                        default => [0]
                    })
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('datasetable_type')
                    ->formatStateUsing(fn ($state) => $state == 'App\Models\User' ? 'User' : 'Group')
                    ->label('Sharing type (Group or User)'),
                Tables\Columns\TextColumn::make('datasetable.name')
                    ->label('Name'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Give access'),
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
