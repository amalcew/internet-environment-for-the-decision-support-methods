<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ElectreOneResource\RelationManagers\ElectreTriCriteriaSettingsRelationMenager;
use App\Filament\App\Resources\ElectreOneResource\RelationManagers\ElectreTriProfilesRelationManager;
use App\Filament\App\Resources\ElectreTriResource\Pages;
use App\Models\ElectreTri;
use App\Service\MethodService\Mappers\ElectreTriMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
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
        self::guardElectre();
        $record = $form->getRecord();
        $editSchema = [];
        if ($record) {
            $editSchema[] = Forms\Components\TextInput::make('lambda')
                ->required()
                ->numeric();
            $editSchema[] = Forms\Components\TextInput::make('tag')
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
                Tables\Columns\TextColumn::make('tag'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
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
}
