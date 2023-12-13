<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ElectreTriResource\Pages;
use App\Models\ElectreTri;
use App\Service\MethodService\Mappers\ElectreTriMapper;
use App\Service\MethodService\MethodFacade;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ElectreTriResource extends Resource
{
    protected static ?string $model = ElectreTri::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Electre Tri';
    protected static ?string $modelLabel = 'Electre Tri';
    protected static ?string $pluralModelLabel = 'Electre Tri';

    protected static ?string $navigationGroup = 'Methods';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('project_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('lambda')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lambda')
                    ->numeric()
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
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
        /** @var ElectreTri $record */
        $record = $infolist->getRecord();
        $record = self::initAndCalculateElectre($record);
        $valuesGrid[] = TextEntry::make('variants')->listWithLineBreaks(true);
        return $infolist->schema([
            Section::make('dataset values')
                ->schema([
                    Section::make('aaa')
                        ->schema(
                            $valuesGrid
                        )
                        ->columns(2)
                ])
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
}
