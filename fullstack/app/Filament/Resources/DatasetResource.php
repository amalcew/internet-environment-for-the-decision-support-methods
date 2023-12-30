<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DatasetResource\Pages;
use App\Filament\Resources\DatasetResource\RelationManagers;
use App\Models\Dataset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DatasetResource extends \App\Filament\App\Resources\DatasetResource
{
    protected static ?string $model = Dataset::class;


    public static function table(Table $table): Table
    {
        $table = parent::table($table);
        $table->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make()
                ->authorize(true)
                ->label('share with others'),
        ]);
        return $table;
    }
}
