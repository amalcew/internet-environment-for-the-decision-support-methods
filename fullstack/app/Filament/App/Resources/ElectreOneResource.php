<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ElectreOneResource\Pages;
use App\Filament\App\Resources\ElectreOneResource\RelationManagers;
use App\Infolists\Components\Electre1sGraph;
use App\Infolists\Components\TestEntry;
use App\Models\Dataset;
use App\Models\ElectreOne;
use App\Models\Project;
use App\Models\Variant;
use App\Service\MethodService\Mappers\Electre1sMapper;
use App\Service\MethodService\MethodFacade;
use App\Service\MethodService\Transfers\Electre1sRequestDTO;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

FilamentAsset::register([
    Js::make('external-script', 'https://d3js.org/d3.v4.min.js'),
    Js::make('external-script', 'https://d3js.org/d3-selection-multi.v1.js'),
    Js::make('graph', __DIR__ . '/../../../../resources/js/graph.js'),
]);

class ElectreOneResource extends Resource
{
    protected static ?string $model = ElectreOne::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\Select::make('project_id')
//                    ->relationship('project', 'name')
//                    ->required(),
                Forms\Components\TextInput::make('lambda')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        /** @var ElectreOne $record */
        $record = $infolist->getRecord();
        $record = self::initAndCalculateElectre($record);

        $variants = Filament::getTenant()->variants;
        $record->variants = $variants;

        $variantCount = $variants->count();
        $concordanceColumns = [TextEntry::make('variants')->listWithLineBreaks(true)];
        $disconcordanceColumns = [TextEntry::make('variants')->listWithLineBreaks(true)];
        $combinedColumns = [TextEntry::make('variants')->listWithLineBreaks(true)];
        $relationsColumns = [TextEntry::make('variants')->listWithLineBreaks(true)];

        foreach ($variants as $i => $variant) {
            $concordanceColumns[] = TextEntry::make('concordance.' . $i)->listWithLineBreaks(true)->label($variant->name);
            $disconcordanceColumns[] = TextEntry::make('discordance.' . $i)->listWithLineBreaks(true)->label($variant->name);
            $combinedColumns[] = TextEntry::make('final.' . $i)->listWithLineBreaks(true)->label($variant->name);
            $relationsColumns[] = TextEntry::make('relations.' . $i)->listWithLineBreaks(true)->label($variant->name);
        }

        return $infolist->schema([
            TextEntry::make('lambda'),
            Section::make('tables')
                ->schema([
                    Section::make('concordance')
                        ->schema(
                            $concordanceColumns
                        )
                        ->columns($variantCount + 1),
                    Section::make('discordance')
                        ->schema(
                            $disconcordanceColumns
                        )
                        ->columns($variantCount + 1),
                    Section::make('final')
                        ->schema(
                            $combinedColumns
                        )
                        ->columns($variantCount + 1),
                    Section::make('relations')
                        ->schema(
                            $relationsColumns
                        )
                        ->columns($variantCount + 1),
//                    Electre1sGraph::make('clean_graph'),
                    ViewEntry::make('status')
                    ->view('infolists.components.electre1s-graph')
                ]),

        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ElectreCriteriaSettingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListElectreOnes::route('/'),
            'create' => Pages\CreateElectreOne::route('/create'),
            'view' => Pages\ViewElectreOne::route('/{record}'),
            'edit' => Pages\EditElectreOne::route('/{record}/edit'),
        ];
    }

    /**
     * @param ElectreOne $record
     * @return ElectreOne
     */
    public static function initAndCalculateElectre(ElectreOne $record): ElectreOne
    {
        try {
            $facade = new MethodFacade();
            $dto = (new Electre1sMapper)->generateDTOfromElectre1sModel($record);
            $body = $facade->getElectre1sData($dto, true);
            foreach ($body as $key => $matrix) {
                $record[$key] = $matrix;
            }
            return $record;
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            dd("Most likely there is error connection with spring engine. Check if you have your spring app running");
        }
    }
}
