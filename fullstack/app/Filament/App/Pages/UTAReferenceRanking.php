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
        $jsonRequest = '
            {
                "performanceTable": [[3, 10, 1], [4, 20, 2], [2, 20, 0], [6, 40, 0], [30, 30, 3]],
                "criteriaMinMax": ["min", "min", "max"],
                "criteriaNumberOfBreakPoints": [3,4,4],
                "epsilon": 0.05,
                "rownamesPerformanceTable": ["RER","METRO1","METRO2","BUS","TAXI"],
                "colnamesPerformanceTable": ["Price","Time","Comfort"],
                "alternativesPreferences": [ ["METRO2","TAXI"]],
                "alternativesIndifferences": [["BUS","RER"]]
             }';
        $json = ' {"optimum":[0],"valueFunctions":{"Price":[[30,16,2],[0,0.525,0.525]],"Time":[[40,30,20,10],[0,0,0,0]],"Comfort":[[0,1,2,3],[0,0,0,0.475]]},"overallValues":[0.525,0.525,0.525,0.475],"ranks":[1,1,1,4],"errors":[0,0,0,0],"Kendall":{},"minimumWeightsPO":{},"maximumWeightsPO":{},"averageValueFunctionsPO":{}}';
        $uta_response = json_decode($json);
        $uta_request = json_decode($jsonRequest);
        //    dd($uta_response->valueFunctions);
        $this->widgetData = [
            'custom_title' => "Create your own reference ranking",
            'list' => $variants->toArray(),
            'selected' => [],
            'final_ranking' => $this->zipArrays($uta_response->overallValues, $uta_response->ranks, $uta_request->rownamesPerformanceTable), // TODO request to UTA endpoint,
            'chart_data' => $uta_response->valueFunctions];
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
            return in_array($variant['id'], $this->widgetData['selected']);
        });
    }

    function zipArrays($arr1, $arr2, $arr3)
    {
        $zippedArray = [];
        for ($i = 0; $i < count($arr1); $i++) {
            $zippedArray[] = [$arr1[$i], $arr2[$i], $arr3[$i]];
        }
        return $zippedArray;
    }

}
