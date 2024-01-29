<?php

namespace App\Filament\App\Resources\UtaResource\Pages;

use App\Filament\App\Pages\UTAReferenceRanking;
use App\Filament\App\Resources\UtaResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewUta extends ViewRecord
{
    protected static string $resource = UtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('solve')
                ->label(__('Solve'))
                ->url(UTAReferenceRanking::getUrl(['record' => $this->getRecord()->id]))
                ->icon('heroicon-s-play')
                ->iconPosition('after')
        ];
    }
}
