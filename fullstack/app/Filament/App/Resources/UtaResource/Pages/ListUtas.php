<?php

namespace App\Filament\App\Resources\UtaResource\Pages;

use App\Filament\App\Pages\UTAReferenceRanking;
use App\Filament\App\Resources\UtaResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListUtas extends ListRecords
{
    protected static string $resource = UtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('solve')
                ->label('Solve')
                ->url(UTAReferenceRanking::getUrl())
                ->icon('heroicon-s-play')
            ->iconPosition('after')
        ];
    }
}
