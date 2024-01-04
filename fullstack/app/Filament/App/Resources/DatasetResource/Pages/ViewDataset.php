<?php

namespace App\Filament\App\Resources\DatasetResource\Pages;

use App\Filament\App\Resources\DatasetResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

FilamentAsset::register([
    Css::make('electre-one-stylesheet', __DIR__ . '/../../../../resources/css/matrix.css'),
]);

class ViewDataset extends ViewRecord
{
    protected static string $resource = DatasetResource::class;
    protected ?string $maxContentWidth = 'full';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('share with others'),
            Actions\ViewAction::make()->action(fn() => $this->redirect(Filament::getTenantProfileUrl()))
                ->label('Attach')
        ];
    }
}
