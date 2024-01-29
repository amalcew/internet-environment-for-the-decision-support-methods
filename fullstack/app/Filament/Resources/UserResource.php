<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('user')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->inlineLabel(),
                        Forms\Components\TextInput::make('email')
                            ->label(__('User email'))
                            ->inlineLabel(),
                    ])
                    ->label('')
                    ->columns(1)
                    ->disabled(),
                Forms\Components\Select::make('group_id')
                    ->label(__('Group'))
                    ->relationship('group', 'name'),
                Forms\Components\TextInput::make('is_admin')
                    ->label(__('Is admin'))
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Section::make()
                ->schema([
                    Forms\Components\TextInput::make('password')
                    ->label(__('New Password'))
                    ->password()
                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                    ->rule(Password::default())
                    ->same('confirm_password'),
                    Forms\Components\TextInput::make('confirm_password')
                    ->label(__('Confirm Password'))
                    ->password()
                    ->dehydrated(false)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('User email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('group.name')
                    ->label(__('Group'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_admin')
                    ->label(__('Is admin'))
                    ->formatStateUsing(fn ($state) => $state ? __('Yes') : __('No'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
