<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ConclusionResource\Pages;
use App\Filament\App\Resources\ConclusionResource\RelationManagers;
use App\Infolists\Components\MyMarkdownEntry;
use App\Models\Conclusion;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConclusionResource extends Resource
{
    protected static ?string $model = Conclusion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 999;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
//                Forms\Components\RichEditor::make()
                Forms\Components\MarkdownEditor::make('text')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        // no idea how to disable table. Workaround
        $proj = Filament::getTenant();
        $conclusion = $proj->conclusions()->first();
        if ($conclusion) {
            redirect(self::getUrl('view', [$conclusion]));
        }
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email'),
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
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('text')
                    ->label("Your projects conclusion")
                    ->extraAttributes([
                        'class' => 'my-markdown'
                    ])
                    ->markdown(),
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
            'index' => Pages\ListConclusions::route('/'),
            'create' => Pages\CreateConclusion::route('/create'),
            'view' => Pages\ViewConclusion::route('/{record}'),
            'edit' => Pages\EditConclusion::route('/{record}/edit'),
        ];
    }
}
