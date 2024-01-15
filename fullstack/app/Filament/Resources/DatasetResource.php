<?php

namespace App\Filament\Resources;

use App\Filament\App\Resources\DatasetResource\RelationManagers\DatasetablesRelationManager;
use App\Filament\Resources\DatasetResource\Pages;
use App\Filament\Resources\DatasetResource\RelationManagers;
use App\Models\Dataset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

    public static function getNavigationLabel(): string
    {
        return __('Datasets');
    }
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        $record = $form->getRecord();
        // edit form - only attach users
        if ($record) {
            return $form->schema([
                Forms\Components\Placeholder::make('Share with other users')
                    ->label(__('Share'))
            ]);
        }
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Forms\Components\FileUpload::make('csv_file')
                    ->label(__('Csv file'))
                    ->required()
                    ->storeFiles(false),
                Forms\Components\Placeholder::make('CSV info')
                    ->label(__('Formatting requirements'))
                    ->content(new HtmlString(__("Header must be composed of two data rows:<br>- First row contains required keyword <b>'variants'</b> and names of each criteria:<br><br><b>variants</b>,criterion1,criterion2, ...<br><br>- Second row contains information about the type of criteria: <b>c</b> for cost and <b>g</b> for gain. Keyword 'variants' have to be included as blank:<br><br>,c,g,g,c, ...<br><br>- Desired delimiter for dataset file is comma (,) or semicolon (;).<br><br><br>Example file content:<br><br>variants,cost,gain<br>,c,g<br>var1,100.0,100<br>var2,200.0,500<br>var3,500.0,1000<br>var4,300.0,1000<br>")))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label(__('Share')),
                Tables\Actions\DeleteAction::make('delete')
                ->requiresConfirmation()
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDatasets::route('/'),
            'create' => Pages\CreateDataset::route('/create'),
            'view' => Pages\ViewDataset::route('/{record}'),
            'edit' => Pages\EditDataset::route('/{record}/edit'),
        ];
    }
    public static function getRelations(): array
    {
        return [
            DatasetablesRelationManager::class
        ];
    }
}
