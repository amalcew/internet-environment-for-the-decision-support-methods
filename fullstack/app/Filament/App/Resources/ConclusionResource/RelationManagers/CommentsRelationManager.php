<?php

namespace App\Filament\App\Resources\ConclusionResource\RelationManagers;

use App\Models\Comment;
use App\Policies\CommentPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Comments');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('text')
                    ->label(__('Text'))
                    ->required()
                    ->maxLength(999),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('text')
                ->label(__('Text')),
                Tables\Columns\TextColumn::make('user.email')
                    ->label(__('User')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->authorize(true) //visibility in view page -> only owner will access edit page
                ->mutateFormDataUsing(function ($data) {
                    $data['user_id'] = auth()->id();
                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->authorize(fn (Comment $comment) => auth()->user()->can('update', $comment)),
                Tables\Actions\DeleteAction::make()
                ->authorize(fn (Comment $comment) => auth()->user()->can('delete', $comment))
            ]);
    }
}
