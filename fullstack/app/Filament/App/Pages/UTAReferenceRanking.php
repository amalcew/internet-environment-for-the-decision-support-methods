<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;

class UTAReferenceRanking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.app.pages.utaInterface';

    public $widgetData;

    public function mount(): void
    {
        $this->widgetData = [
            'custom_title' => "Your Title Here",
            'custom_content' => "Your content here",
            'list' => [
                'item 1',
                'item 2',
                'item 3',
            ],
        ];
    }

    /**
     * No idea why it runs here and not on ReferenceTable
     * @param $sortOrder
     * @param $previousSortOrder
     * @param $name
     * @param $from
     * @param $to
     * @return void
     */
    public function handleSortOrderChange($sortOrder, $previousSortOrder, $name, $from, $to)
    {
        $this->widgetData['list'] = $sortOrder;
    }

}
