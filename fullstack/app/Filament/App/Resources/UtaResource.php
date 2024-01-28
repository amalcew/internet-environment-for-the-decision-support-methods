<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\UtaResource\Pages;
use App\Filament\App\Resources\UtaResource\RelationManagers\UtaCriteriaSettingsRelationManager;
use App\Models\Uta;
use App\Service\MethodService\Mappers\UTAMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Infolists\Components\Section;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
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

    public static function getNavigationGroup(): string
    {
        return __('Methods');
    }

    public static function form(Form $form): Form
    {
        self::guardUta();
        $record = $form->getRecord();
        $editSchema = [];
        if ($record) {
            $editSchema[] = Forms\Components\TextInput::make('epsilon')
                ->label(__('Epsilon'))
                ->required()
                ->numeric();
        }
        return $form
            ->schema($editSchema);
    }

    public static function table(Table $table): Table
    {
        self::guardUta();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable(),
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
            UTACriteriaSettingsRelationManager::class,
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

    public static function initAndCalculateUTA(Uta $record): Uta
    {
        try {
            $facade = new MethodFacade();
            $dto = (new UTAMapper())->generateDTOfromUTAModel($record);
            $body = $facade->getUTAData($dto, false);
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
    public static function guardUta(): void
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
