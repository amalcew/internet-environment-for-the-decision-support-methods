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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class ElectreTriCriteriaSettingsRelationMenager extends RelationManager
{
    protected static string $relationship = 'electreTriCriteriaSettings';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Criteria Settings');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('criterion')
                    ->label(__('Criterion'))
                    ->relationship('criterion')->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->inlineLabel()
                    ])
                    ->label('')
                    ->columns(1)
                    ->disabled(),
                Forms\Components\TextInput::make('weight')
                    ->label(__('Weight'))
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
                Forms\Components\Checkbox::make('use_veto')
                    ->label(__("Use veto"))
            ])
            ->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('criterion.name')
                    ->label(__('Criterion')),
                Tables\Columns\TextColumn::make('weight')
                    ->label(__('Weight')),
                Tables\Columns\TextColumn::make('q'),
                Tables\Columns\TextColumn::make('p'),
                Tables\Columns\TextColumn::make('v'),
                Tables\Columns\CheckboxColumn::make('use_veto')
                    ->label(__('Use veto'))
                    ->disabled(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                SelectFilter::make('criterion')
                    ->label(__("Criterion"))
                    ->relationship('criterion', 'name', function (Builder $query) {
                        $proj = Filament::getTenant();
                        $dataset = $proj->dataset;
                        return $query->whereBelongsTo($dataset);
                    })
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->label(__("Type"))
                    ->options([
                        'cost' => 'cost',
                        'gain' => 'gain',
                    ])
                    ->searchable()
                    ->preload()
            ]);
    }
}
