<?php

namespace App\Filament\App\Pages;

use App\Models\Variant;
use Filament\Pages\Page;

class UTAReferenceRanking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.app.pages.utaInterface';

    protected static bool $shouldRegisterNavigation = false;

    public $widgetData;

    public function mount(): void
    {
        $variants = Variant::all();
      //  dd($variants->pluck('name')->toArray());
        $this->widgetData = [
            'custom_title' => "Your Title Here",
            'custom_content' => "Your content here",
            'list' => $variants->toArray(),
            'selected' => [],
            'final_ranking' => [] // TODO request to UTA endpoint
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
       // dd($this->widgetData['list']);
    }

    public function handleSortOrderChangeSorted($sortOrder, $previousSortOrder, $name, $from, $to)
    {
        $this->widgetData['selected'] = $sortOrder;
        $variants = Variant::all()->toArray();
        $filteredObjects = array_filter($variants, function ($variant) {
            return  in_array($variant['id'], $this->widgetData['selected']);
        });
        dd($filteredObjects);
    }

}
