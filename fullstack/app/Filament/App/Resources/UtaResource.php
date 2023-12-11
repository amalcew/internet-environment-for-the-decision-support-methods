<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\UtaResource\Pages;
use App\Models\Uta;
use App\Service\MethodService\Mappers\UTAMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Forms;
use Filament\Infolists\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UtaResource extends Resource
{
    protected static ?string $model = Uta::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Uta';

    protected static ?string $modelLabel = 'Uta';
    protected static ?string $pluralModelLabel = 'Uta';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('project_id')
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
            'index' => Pages\ListUtas::route('/'),
            'create' => Pages\CreateUta::route('/create'),
            'view' => Pages\ViewUta::route('/{record}'),
            'edit' => Pages\EditUta::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        /** @var Uta $record */
        $record = $infolist->getRecord();
        $record = self::initAndCalculateUTA($record);
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

    public static function initAndCalculateUTA(Uta $record): Uta
    {
        try {
            $facade = new MethodFacade();
            $dto = (new UTAMapper())->generateDTOfromUTAModel($record);
            $body = $facade->getUTAData($dto, true);
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
