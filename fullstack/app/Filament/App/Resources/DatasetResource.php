<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\DatasetResource\Helper\QueryHelper;
use App\Filament\App\Resources\DatasetResource\Pages;
use App\Filament\App\Resources\DatasetResource\RelationManagers;
use App\Imports\DatasetImport;
use App\Infolists\Components\TestEntry;
use App\Models\Criterion;
use App\Models\Dataset;
use App\Models\ElectreOne;
use App\Models\Value;
use App\Models\Variant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

    public static function getNavigationLabel(): string
    {
        return __('Datasets');
    }

//    change tenant filter to user filter
    public static function scopeEloquentQueryToTenant(Builder $query, ?Model $tenant): Builder
    {
        return QueryHelper::adjustQueryForDatasetAccess($query);
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->label(__('Edit')),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        /** @var Dataset $record */
        $record = $infolist->getRecord();
        $valuesGrid = [];
        /** @var Collection<Criterion> $criteria */
        $criteria = $record->criteria()->with('values')->get();
        $record->variants()->get();
        $criteriaCount = $criteria->count();
        $groupedValues = [];
        foreach ($criteria as $criterion) {
            $groupedValues[$criterion->name] = $criterion->values()->whereNot('variant_id', null)->get()->sortBy('variant_id');
        }
        //        saving will throw an error
        $record->groupedValues = $groupedValues;
        $valuesGrid[] = TextEntry::make('variants')->label(__('Variants'))->listWithLineBreaks(true);
        foreach ($groupedValues as $key => $value) {
            $valuesGrid[] = TextEntry::make('groupedValues.' . $key)->listWithLineBreaks(true)->label($key);
        }
        return $infolist->schema([
            Section::make(__('Values'))
                ->schema([
                    Grid::make(['default' => $criteriaCount + 1])
                        ->schema($valuesGrid)
                        ->columnSpan(['default' => 65,]),
                    ])
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DatasetablesRelationManager::class
        ];
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
}
