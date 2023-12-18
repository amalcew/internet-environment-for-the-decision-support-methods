<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\ProjectUserResource\Pages;
use App\Models\ProjectUser;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProjectUserResource extends Resource
{
    protected static ?string $model = ProjectUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationLabel = 'Share project with others';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'email')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->action(function (Model $record): void {
                        $owner = $record->project->user_id;
                        $currentUser = Filament::auth()->user()->id;
                        if ($record->user_id == $owner) {
                            Notification::make()
                                ->title('Cannot delete project owner')
                                ->danger()
                                ->send();
                        } else if ($record->user_id == $currentUser) {
                            // TODO: redirect user to dashboard instead declining the deletion
                            Notification::make()
                                ->title('Cannot delete currently logged user')
                                ->danger()
                                ->send();
                        } else {
                            $record->delete();
                        }
                    })
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
            'index' => Pages\ListProjectUsers::route('/'),
            'create' => Pages\CreateProjectUser::route('/create'),
            //'view' => Pages\ViewProjectUser::route('/{record}'),
            //'edit' => Pages\EditProjectUser::route('/{record}/edit'),
        ];
    }
}
