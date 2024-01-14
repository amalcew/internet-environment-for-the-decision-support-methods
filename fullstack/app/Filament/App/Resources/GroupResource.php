<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\GroupResource\Pages;
use App\Filament\App\Resources\GroupResource\RelationManagers;
use App\Models\Group;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // turn of filter
    public static function scopeEloquentQueryToTenant(Builder $query, ?Model $tenant): Builder
    {
        return $query;
    }

    public static function form(Form $form): Form
    {
        $year = date("Y");
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('class_year')
                    ->label(__('Class year'))
                    ->required()
                    ->default($year)
                    ->maxLength(255),
                Forms\Components\TextInput::make('class_time')
                    ->label(__('Class time'))
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('Creator'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('class_year')
                    ->label(__('Class year'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('class_time')
                    ->label(__('Class time'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('attach_user')
                ->label(function ($record) {
                    $user = auth()->user();
                    return $user->group_id == $record->id ? __("Leave") : __("Join");
                })
                ->action(function ($record) {
                    /** @var Group $record */
                    $user = auth()->user();
                    if ($user->group_id == $record->id) {
                        $user->group_id = null;
                    } else {
                        $user->group_id = $record->id;
                    }
                    $user->save();
//                    give group owner(teacher) access
                    $projects = $user->myProjects;
                    $owner = $record->user;
                    $projects->each(function ($project) use ($owner) {
                        try {
                            ProjectUser::create([
                                'project_id' => $project->id,
                                'user_id' => $owner->id
                            ]);
                        } catch (\Exception $exception) {
                            // most likely unique constraint
                        }

                    });
                })
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'view' => Pages\ViewGroup::route('/{record}'),
            'edit' => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}
