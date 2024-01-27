<?php

namespace App\Filament\App\Resources\DatasetResource\Pages;

use App\Filament\App\Resources\DatasetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class EditDataset extends EditRecord
{
    protected static string $resource = DatasetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('Edit Dataset');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->modalDescription(function ($record) {
                    $str = __('Related projects (they will be deleted too!):<br>');
                    foreach ($record->projects as $proj) {
                        $str .= $proj->id . ' - '.$proj->name . '<br>';
                    };
                    return new HtmlString($str);
                })
        ];
    }
}
