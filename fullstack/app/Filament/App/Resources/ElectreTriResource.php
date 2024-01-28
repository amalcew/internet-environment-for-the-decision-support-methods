<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ElectreOneResource\Components\ElectreLabel;
use App\Filament\App\Resources\ElectreOneResource\RelationManagers\ElectreTriCriteriaSettingsRelationMenager;
use App\Filament\App\Resources\ElectreOneResource\RelationManagers\ElectreTriProfilesRelationManager;
use App\Filament\App\Resources\ElectreTriResource\Pages;
use App\Models\ElectreTri;
use App\Service\MethodService\Mappers\ElectreTriMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
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
use stdClass;

class ElectreTriResource extends Resource
{
    protected static ?string $model = ElectreTri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Electre Tri';
    protected static ?string $modelLabel = 'Electre Tri';
    protected static ?string $pluralModelLabel = 'Electre Tri';

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

    public static function getRelations(): array
    {
        return [
            ElectreTriCriteriaSettingsRelationMenager::class,
            ElectreTriProfilesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListElectreTris::route('/'),
            'create' => Pages\CreateElectreTri::route('/create'),
            'view' => Pages\ViewElectreTri::route('/{record}'),
            'edit' => Pages\EditElectreTri::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        FilamentAsset::register([
            Css::make('electre-one-stylesheet', __DIR__ . '/../../../../resources/css/matrix.css'),
        ]);
        /** @var ElectreTri $record */
        $record = $infolist->getRecord();
        $record = self::initAndCalculateElectre($record);
        $variants = Filament::getTenant()->variants;
        $record->variants = $variants;
        $electreTriProfiles = $record->electreTriProfile()->get();
        $combinedVariants = $variants->concat($electreTriProfiles);
        $variantCount = $variants->count();
        $combinedvariantCount = $combinedVariants->count();
        $matrixBeforeLambdaData = $record->matrix_before_lambda;
        $finalData = $record->final;
        $sMatrixData = $record->sMatrix;
        $transformedSMatrix = self::transformSMatrix($sMatrixData, [
            'P' => 'P',
            'minusP' => '-P',
            'R' => 'R'
        ]);
        $optimisticData = $record->optimistic;
        $pessimisticData = $record->pessimistic;
        $concordanceColumns = self::getConcordanceColumns($variants, $combinedVariants, $record->concordance);
        $discordanceTabs = self::getDiscordanceTabs($record->discordance, $electreTriProfiles->count(), $combinedVariants);
        $matrixBeforeLambdaColumns = self::createMatrixColumns($variants, $matrixBeforeLambdaData, $combinedVariants);
        $matrixAfterLambdaColumns = self::createMatrixColumns($variants, $finalData, $combinedVariants);
        $sMatrixColumns = self::createMatrixColumns($variants, $transformedSMatrix, $combinedVariants);
        $optimisticClassification = self::createVariantClassesColumns($variants, $optimisticData);
        $pessimisticClassification = self::createVariantClassesColumns($variants, $pessimisticData);
        return $infolist->schema([
            Tabs::make('Data Tabs')
                ->tabs([
                    Tabs\Tab::make(__('Concordance & Discordance'))
                        ->schema([
                            Section::make(__('Concordance'))
                                ->schema([
                                    Grid::make(['default' => $combinedvariantCount + 2])
                                        ->schema($concordanceColumns)
                                        ->columnSpan(['default' => 65,]),
                                ])->collapsible(),
                            Tabs::make(__('Discordance'))
                                ->tabs([
                                    ...$discordanceTabs
                                ])
                        ]),
                    Tabs\Tab::make(__('Outranking relations'))
                        ->schema([
                            Section::make(__('Without lambda validation'))
                                ->schema([
                                    Grid::make(['default' => $combinedvariantCount + 2])
                                        ->schema($matrixBeforeLambdaColumns)
                                        ->columnSpan(['default' => 65,]),
                                ])->collapsible(),
                            Section::make(__('With lambda validation'))
                                ->schema([
                                    Grid::make(['default' => $combinedvariantCount + 2])
                                        ->schema($matrixAfterLambdaColumns)
                                        ->columnSpan(['default' => 65,]),
                                ])->collapsible()
                        ]),
                    Tabs\Tab::make(__('Outranking final relations'))
                        ->schema([
                            Section::make(__('Without lambda validation'))
                                ->schema([
                                    Grid::make(['default' => $combinedvariantCount + 2])
                                        ->schema($sMatrixColumns)
                                        ->columnSpan(['default' => 65,]),
                                ])->collapsible()
                        ]),
                    Tabs\Tab::make(__('Classification'))
                        ->schema([
                            Section::make(__('Optimistic'))
                                ->schema([
                                    Grid::make(['default' => $variantCount])
                                        ->schema($optimisticClassification)
                                        ->columnSpan(['default' => 65,]),
                                ])->collapsible(),
                            Section::make(__('Pessimistic'))
                                ->schema([
                                    Grid::make(['default' => $variantCount])
                                        ->schema($pessimisticClassification)
                                        ->columnSpan(['default' => 65,]),
                                ])->collapsible()
                        ]),
                ])
                ->columnSpanFull()

        ]);
    }


    public static function initAndCalculateElectre(ElectreTri $record): ElectreTri
    {
        try {
            $facade = new MethodFacade();
            $dto = (new ElectreTriMapper())->generateDTOfromElectreTriModel($record);
            $body = $facade->getElectreTriData($dto, true);
            foreach ($body as $key => $matrix) {
                $record[$key] = $matrix;
            }
            return $record;
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
            dd("Most likely there is error connection with spring engine. Check if you have your spring app running");
        }
    }
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

    public static function validateProject(): bool
    {
        $proj = Filament::getTenant();
        if (!$proj->dataset) {
            return false;
        }
        return true;
    }

    /**
     * @param mixed $variants
     * @return array
     */
    public static function getConcordanceColumns(mixed $variants, $combinedVariants, $concordance): array
    {
        $variantNames = collect($combinedVariants)->map(fn($variant) => $variant->name);
        $concordanceColumns = [
            TextEntry::make('variantNames')
                ->default($variantNames) // Set the concatenated names as the default value
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel(__('Variants')))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];
        $combinedVariantsMapped = self::mapToStdClass($combinedVariants);
        foreach ($combinedVariantsMapped as $i => $variant) {
            $concordanceColumns[] = TextEntry::make("concordance.". $i)
                ->listWithLineBreaks(true)
                ->label(new ElectreLabel($variant->name))
                ->numeric(decimalPlaces: 2, decimalSeparator: '.', thousandsSeparator: ',');
        }
        return $concordanceColumns;
    }

    public static function getDiscordanceTabs($discordanceData, $variantCount, $variants): array
    {
        $discordanceTabs = [];
        $index = 0;

        foreach ($discordanceData as $matrixIndex => $matrix) {
            $matrixColumns = self::createDiscordcanceMatrixColumns($matrix, $variantCount, $variants);
            $discordanceTabs[] = Tabs\Tab::make($variants[$index]->name)
                ->schema([
                    Section::make($variants[$index]->name)
                        ->schema([
                            Grid::make(['default' => $variantCount + count($matrixColumns)])
                                ->schema($matrixColumns)
                                ->columnSpan(['default' => 65,]),
                        ])->collapsible(),
                ]);
            $index+=1;
        }

        return $discordanceTabs;
    }

    private static function createDiscordcanceMatrixColumns($matrix, $variantCount, $variants): array
    {
        $variantNames = collect($variants)->map(fn($variant) => $variant->name);
        $columns = [
            TextEntry::make('$variantNames')
                ->default($variantNames)
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel(__('Variants')))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];
        foreach ($matrix as $rowIndex => $row) {
            $columns[] = TextEntry::make('discordance'. $rowIndex)
                ->listWithLineBreaks(true)
                ->label(new ElectreLabel('P' . $rowIndex+1))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
                ->numeric(decimalPlaces: 2, decimalSeparator: '.', thousandsSeparator: ',')
                ->default($row);
        }
        return $columns;
    }

    public static function createMatrixColumns(mixed $variants, $matrixData, $combinedVariants): array
    {
        $variantNames = collect($combinedVariants)->map(fn($variant) => $variant->name);

        $matrixColumns = [
            TextEntry::make('$variantNames')
                ->default($variantNames)
                ->listWithLineBreaks(true)
                ->columnSpan(2)
                ->label(new ElectreLabel('Variants'))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
        ];
        foreach ($matrixData as $colIndex => $value) {
            $matrixColumns[] = TextEntry::make('matrix'. $colIndex)
                ->listWithLineBreaks(true)
                ->label(new ElectreLabel($combinedVariants[$colIndex]->name))
                ->weight(FontWeight::Medium)
                ->html()
                ->formatStateUsing(fn(string $state): string => __('<p class="electre-variant">' . $state . '</p>'))
                ->numeric(decimalPlaces: 2, decimalSeparator: '.', thousandsSeparator: ',')
                ->default($value);
        }

        return $matrixColumns;
    }

    public static function createVariantClassesColumns($variants, $variantClasses): array
    {
        $variantClassesColumns = [];

        foreach ($variants as $index => $variant) {
            $class = $variantClasses[$index] ?? 'Unknown'; // Default to 'Unknown' if class is not set

            $variantClassesColumns[] = TextEntry::make('variantClass' . $index)
                ->default($class)
                ->label($variant->name);
        }

        return $variantClassesColumns;
    }


    public static function transformSMatrix($sMatrixData, $replacementValues): array
    {
        // Define the replacements
        $replacements = [
            'INDIFFERENT' => $replacementValues['P'],
            'aSb' => $replacementValues['P'],
            'bSa' => $replacementValues['minusP'],
            'CANNOT_COMPARE' => $replacementValues['R'],
        ];

        $transformedMatrix = [];

        foreach ($sMatrixData as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                // Replace the value based on the mapping
                $transformedMatrix[$rowIndex][$colIndex] = $replacements[$value] ?? $value;
            }
        }

        return $transformedMatrix;
    }

    private static function mapToStdClass($items): array {
        return $items->map(function ($item) {
            $stdObject = new stdClass;
            $stdObject->id = $item->id;
            $stdObject->name = $item->name;
            $stdObject->dataset_id = $item->dataset_id;
            return $stdObject;
        })->all();
    }
}
