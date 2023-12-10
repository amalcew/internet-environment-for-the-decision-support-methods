<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ElectreOneResource\Components\ElectreLabel;
use App\Filament\App\Resources\ElectreOneResource\Pages;
use App\Filament\App\Resources\ElectreOneResource\RelationManagers;
use App\Infolists\Components\Electre1sGraph;
use App\Models\ElectreOne;
use App\Models\Variant;
use App\Service\MethodService\Mappers\Electre1sMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Filament\Infolists\Components\Tabs;


class ElectreOneResource extends Resource
{
    protected static ?string $model = ElectreOne::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        self::guardElectre();
        $record = $form->getRecord();
        $editSchema = [];
        if ($record) {
            $editSchema[] = Forms\Components\TextInput::make('lambda')
                ->required()
                ->numeric();
        }
        return $form
            ->schema($editSchema);
    }

    public static function table(Table $table): Table
    {
        self::guardElectre();
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
        FilamentAsset::register([
            Js::make('external-script', 'https://d3js.org/d3.v4.min.js'),
            Js::make('external-script', 'https://d3js.org/d3-selection-multi.v1.js'),
            Js::make('graph', __DIR__ . '/../../resources/js/graph.js'),
        ]);


        /** @var ElectreOne $record */
        $record = $infolist->getRecord();
        $record = self::initAndCalculateElectre($record);
        $variants = Filament::getTenant()->variants;
        $record->variants = $variants;


        $variantCount = $variants->count();
        $concordanceColumns = [TextEntry::make('variants')->listWithLineBreaks(true)->label(new ElectreLabel('Variants'))];
        $disconcordanceColumns = [TextEntry::make('variants')->listWithLineBreaks(true)->label(new ElectreLabel('Variants'))];
        $combinedColumns = [TextEntry::make('variants')->listWithLineBreaks(true)->label(new ElectreLabel('Variants'))];
        $relationsColumns = [TextEntry::make('variants')->listWithLineBreaks(true)->label(new ElectreLabel('Variants'))];


        foreach ($variants as $i => $variant) {
            $concordanceColumns[] = TextEntry::make('concordance.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
            $disconcordanceColumns[] = TextEntry::make('discordance.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
            $combinedColumns[] = TextEntry::make('final.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
            $relationsColumns[] = TextEntry::make('relations.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
        }
        $graphData = self::mapFullRelationsMatrixToGraphData($record->relations, $variants);

//        graphs have to be in 1 tab!! Otherwise weird bugs with d3 display
        FilamentAsset::registerScriptData([
            'graphs' => [
                'final_outranking_graph' => $graphData,
                'full_outranking_graph' => $graphData
            ]
        ]);


        return $infolist->schema([
            Tabs::make('tabs')
                ->tabs([
                    Tabs\Tab::make('graphs')
                        ->schema([
                            TextEntry::make('lambda'),
                            Section::make('outranking graph')
                                ->schema([
                                    Electre1sGraph::make('final_outranking_graph')
                                        ->viewData(['graphId' => 'final_outranking_graph', 'graphData' => $graphData])
                                ]),
                            Section::make('final outranking graph')
                                ->schema([
                                    Electre1sGraph::make('full_outranking_graph')
                                        ->viewData(['graphId' => 'full_outranking_graph', 'graphData' => $graphData])
                                ]),
                        ])->columnSpanFull(),
                    Tabs\Tab::make('tables')
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
                        ])->columnSpanFull(),
                ])
            ->columnSpanFull()
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

    /**
     * @param array $matrix
     * @param Collection<Variant> $variants
     * @return array
     */
    private static function mapFullRelationsMatrixToGraphData(array $matrix, $variants): array
    {
        $nodes = array();
        $links = array();
        foreach ($variants as $i => $variant) {
            $nodes[] = ['id' => $i, 'name' => $variant->name];
        }
        foreach ($matrix as $x => $row) {
            foreach ($row as $y => $cell) {
                if ($x != $y) { // omit node relation with itself
                    if ($cell == "-P") { // transposed matrix - inverted relationships
                        $links[] = [
                            'source' => $x,
                            'target' => $y
                        ];
                    }
                    if ($cell == "I") {
                        $links[] = [
                            'source' => $x,
                            'target' => $y
                        ];
                    }
                }
            }
        }
        return [
            'nodes' => $nodes,
            'links' => $links
        ];

    }

    /**
     * @return bool
     */
    public static function validateProject(): bool
    {
        $proj = Filament::getTenant();
        if (!$proj->dataset) {
            return false;
        }
        return true;
    }

    /**
     * @return void
     */
    public static function guardElectre(): void
    {
        if (!self::validateProject()) {
            Notification::make()
                ->title('No project assigned! Redirected to dataset. Remember to attach dataset to project!')
                ->danger()
                ->send();
            redirect(DatasetResource::getUrl());
        }
    }
}
