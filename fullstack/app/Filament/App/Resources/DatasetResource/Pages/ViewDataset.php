<?php

namespace App\Filament\App\Resources\DatasetResource\Pages;

use App\Filament\App\Resources\DatasetResource;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Contracts\Support\Htmlable;

FilamentAsset::register([
    Css::make('electre-one-stylesheet', __DIR__ . '/../../../../../../resources/css/matrix.css'),
]);

class ViewDataset extends ViewRecord
{
    protected static string $resource = DatasetResource::class;
    protected ?string $maxContentWidth = 'full';

    public function getTitle(): string|Htmlable
    {
        return __('View Dataset');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label(__('Share')),
            Actions\ViewAction::make()->action(fn() => $this->redirect(Filament::getTenantProfileUrl()))
                ->label(__('Attach'))
        ];
    }
}
