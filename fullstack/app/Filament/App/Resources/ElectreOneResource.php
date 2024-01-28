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
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;


class ElectreOneResource extends Resource
{
    protected static ?string $model = ElectreOne::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Electre 1s';
    protected static ?string $modelLabel = 'Electre 1s';
    protected static ?string $pluralModelLabel = 'Electre 1s';

    public static function getNavigationGroup(): string
    {
        return __('Methods');
    }

    public static function form(Form $form): Form
    {
        self::guardElectre();
        $record = $form->getRecord();
        $editSchema = [];
        if ($record) {
            $editSchema[] = Forms\Components\TextInput::make('lambda')
                ->label(__('Lambda'))
                ->required()
                ->numeric();
            $editSchema[] = Forms\Components\TextInput::make('tag')
                ->label(__('Tag'))
                ->required();
        }
        return $form
            ->schema($editSchema);
    }

    public static function table(Table $table): Table
    {
        self::guardElectre();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tag')
                ->label(__('Tag')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
            Js::make('graph', __DIR__ . '/../../../../resources/js/graph.js'),
            Css::make('electre-one-stylesheet', __DIR__ . '/../../../../../../resources/css/matrix.css'),
        ]);


        /** @var ElectreOne $record */
        $record = $infolist->getRecord();
        $record = self::initAndCalculateElectre($record);
//        TODO: this is another query for variants (1 is in initAndCalculate). We could store them...
        $variants = Filament::getTenant()->variants;
        $record->variants = $variants;
        // TODO: find more elegant way to HTML format
        $variantCount = $variants->count();
        $concordanceColumns = [
            TextEntry::make('variants')
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel(__('Variants')))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];
        $disconcordanceColumns = [
            TextEntry::make('variants')
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel(__('Variants')))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];
        $combinedColumns = [
            TextEntry::make('variants')
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel(__('Variants')))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];
        $relationsColumns = [
            TextEntry::make('variants')
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel(__('Variants')))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];


        foreach ($variants as $i => $variant) {
            $concordanceColumns[] = TextEntry::make('concordance.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name))->numeric(decimalPlaces: 2, decimalSeparator: '.', thousandsSeparator: ',',);
            $disconcordanceColumns[] = TextEntry::make('discordance.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
            $combinedColumns[] = TextEntry::make('final.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
            $relationsColumns[] = TextEntry::make('relations.' . $i)->listWithLineBreaks(true)->label(new ElectreLabel($variant->name));
        }
        $OutrankingGraphData = self::mapFullRelationsMatrixToGraphData($record->relations, $variants);
        $mergedList = self::mergeNodes($variants, $record->merged_nodes);
        $mergedList = self::convertArrayToObjects($mergedList);

        $OutrankingFinalGraphData = self::mapFullRelationsMatrixToGraphData($record->final_relations, $mergedList);
        $OutrankingFinalGraphData = self::filterLinks($OutrankingFinalGraphData);
        // graphs have to be in 1 tab!! Otherwise weird bugs with d3 display
        // TODO: insert final graph data
        FilamentAsset::registerScriptData([
            'graphs' => [
                'outranking_graph' => $OutrankingGraphData,
                'final_graph' => $OutrankingFinalGraphData
            ]
        ]);


        return $infolist->schema([
            Tabs::make('tabs')
                ->tabs([
                    Tab::make('graphs')
                        ->label(__('Graphs'))
                        ->schema([
                            TextEntry::make('lambda')
                            ->label(__('Lambda')),
                            Section::make(__('Outranking graph'))
                                ->schema([
                                    Electre1sGraph::make('outranking_graph')
                                        ->viewData(['graphId' => 'outranking_graph', 'graphData' => $OutrankingGraphData])
                                ])
                                ->collapsible(),
                            Section::make(__('Final graph'))
                                ->schema([
                                    Electre1sGraph::make('final_graph')
                                        ->viewData(['graphId' => 'final_graph', 'graphData' => $OutrankingGraphData])
                                ])
                                ->collapsible(),
                        ])->columnSpanFull(),
                    Tab::make('tables')
                        ->label(__('Tables'))
                        ->schema([
//                            Section::make(__('Marginal concordance'))
//                                ->schema(
//                                    [
//
//                                    Grid::make(['default' => $variantCount + 2])
//                                        ->schema($concordanceColumns)
//                                        ->columnSpan(['default' => 65,]),
//                                        ->contained(false)
//                                    ]
//                                )
//                                ->collapsible(),
                            Section::make(__('Comprehensive concordance'))
                                ->schema(
                                    [
                                        Grid::make(['default' => $variantCount + 2])
                                            ->schema($concordanceColumns)
                                            ->columnSpan(['default' => 65,]),
                                    ]
                                )
                                ->collapsible(),
                            Section::make(__('Discordance'))
                                ->schema(
                                    [
                                        Grid::make(['default' => $variantCount + 2])
                                            ->schema($disconcordanceColumns)
                                            ->columnSpan(['default' => 65,]),
                                    ]
                                )
                                ->collapsible(),
                            Section::make(__('Outranking'))
                                ->schema(
                                    [
                                        Grid::make(['default' => $variantCount + 2])
                                            ->schema($combinedColumns)
                                            ->columnSpan(['default' => 65,]),
                                    ]
                                )
                                ->collapsible(),
                            Section::make(__('Relations'))
                                ->schema(
                                    [
                                        Grid::make(['default' => $variantCount + 2])
                                            ->schema($relationsColumns)
                                            ->columnSpan(['default' => 65,]),
                                    ]
                                )
                                ->collapsible(),
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
            if (is_array($row)) {
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
                        if ($cell == "P") { // transposed matrix - inverted relationships
                            $links[] = [
                                'source' => $y,
                                'target' => $x
                            ];
                        }
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

    public static function mergeNodes($nodes, $mergedNodes) {
        if ($nodes instanceof Collection) {
            $nodes = $nodes->toArray();
        }
        foreach (array_reverse($mergedNodes, true) as $mainNode => $merged) {
            if (!empty($merged)) {
                foreach ($merged as $nodeToMerge) {
                    if (isset($nodes[$mainNode]['name']) && isset($nodes[$nodeToMerge]['name'])) {
                        $nodes[$mainNode]['name'] .= ' + ' . $nodes[$nodeToMerge]['name'];
                    }
                    unset($nodes[$nodeToMerge]);
                }
            }
        }
        return array_values($nodes);
    }

    private static function convertArrayToObjects($array) {
        return array_map(function($item) {
            return (object)$item;
        }, $array);
    }

    private static function filterLinks($data) {
        $nodes = $data['nodes'];
        $links = $data['links'];

        $nodeIds = array_map(function($node) {
            return $node['id'];
        }, $nodes);

        $filteredLinks = array_filter($links, function($link) use ($nodeIds) {
            return in_array($link['source'], $nodeIds) && in_array($link['target'], $nodeIds);
        });

        return ['nodes' => $nodes, 'links' => array_values($filteredLinks)];
    }
}
