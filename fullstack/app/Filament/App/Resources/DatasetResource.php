<?php

namespace App\Filament\App\Resources;

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
use Maatwebsite\Excel\Facades\Excel;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

//    change tenant filter to user filter
    public static function scopeEloquentQueryToTenant(Builder $query, ?Model $tenant): Builder
    {
        $query->whereRelation('user', 'id', '=', auth()->user()->id);
        return $query;
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required(),
                Forms\Components\FileUpload::make('csv_file')
                ->required()
                ->storeFiles(false),
                Forms\Components\Placeholder::make('info')
                ->content(new HtmlString('1 line: variants;<1 kryterium>; <2 kryterium>... <br>
                                    2 line: <empty space>;c;g... <br>
                                    Decimal seperator: "."'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            $groupedValues[$criterion->name] = $criterion->values->sortBy('variant_id');
        }
        //        saving will throw an error
        $record->groupedValues = $groupedValues;
        $valuesGrid[] = TextEntry::make('variants')->listWithLineBreaks(true);
        foreach ($groupedValues as $key => $value) {
            $valuesGrid[] = TextEntry::make('groupedValues.'.$key)->listWithLineBreaks(true)->label($key);
        }

        return $infolist->schema([
            Section::make('dataset values')
                ->schema([
                    Section::make('aaa')
                        ->schema(
                            $valuesGrid
                        )
                        ->columns($criteriaCount+1)
                    ])
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DatasetUsersRelationManager::class,
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
