<?php

namespace App\Filament\Resources\GroupResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Users');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('email')
                    ->label(__('User email'))
                    ->options(fn () => User::all()->pluck('email', 'id'))
                    ->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('email')
            ->columns([
                Tables\Columns\TextColumn::make('email')
                    ->label(__('User email')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->action(fn ($data) => $this->createAction($data))
            ])
            ->actions([
                Tables\Actions\DetachAction::make()
                    ->action(function ($record) {
                        $record->group_id = null;
                        $record->save();
                    }),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->action(fn ($data) => $this->createAction($data))
            ]);
    }
    protected function createAction($data) {
        $user = User::find($data['email']);
        $group = $this->getOwnerRecord();
        $user->group_id = $group->id;
        $user->save();
    }
}
