<?php

namespace App\Filament\App\Pages;

use App\Models\Uta;
use App\Models\Variant;
use App\Service\MethodService\Mappers\UTAMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Log;

class UTAReferenceRanking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.app.pages.utaInterface';

    protected static bool $shouldRegisterNavigation = false;

    private $variants;
    public $widgetData;

    public function mount(): void
    {
        $variants = Variant::all();

        $this->widgetData = [
            'custom_title' => "Create your own reference ranking",
            'list' => $variants->toArray(),
            'selected' => [],
            'final_ranking' => [],
            'chart_data' => []
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
        $variants = Variant::all();
        $this->widgetData['list'] = $this->getStringsByIndices($variants, $sortOrder);
    }

    public function handleSortOrderChangeSorted($sortOrder, $previousSortOrder, $name, $from, $to)
    {
        $variants = Variant::all();
        $this->widgetData['selected'] = $this->getStringsByIndices($variants, $sortOrder);
    }

    function zipArrays($arr1, $arr2, $arr3)
    {
        $zippedArray = [];
        for ($i = 0; $i < count($arr1); $i++) {
            $zippedArray[] = [$arr1[$i], $arr2[$i], $arr3[$i]];
        }
        return $zippedArray;
    }

    function getStringsByIndices($strings, $indices)
    {
        $result = [];
        foreach ($indices as $index) {
            if (isset($strings[$index - 1])) {
                $result[] = $strings[$index - 1];
            }
        }
        return $result;
    }

    function generateFinalRanking()
    {
        $nameArray = array_map(function ($object) {
            return $this->getNameAttribute($object);
        }, $this->widgetData['selected']);

        $ranking = $this->getPairsOfStrings($nameArray);
        $variants = Variant::all();
        $uta = Uta::all();

        $facade = new MethodFacade();
        $dto = (new UTAMapper())->generateDTOfromUTAModel($uta[1], $ranking);
        $body = $facade->getUTAData($dto, false);

        $this->widgetData['chart_data'] = $body->valueFunctions;
        //Log::info(json_encode($body->valueFunctions));
        Log::info(json_encode($this->widgetData['chart_data']));
        $this->widgetData['final_ranking'] = $this->zipArrays($body->overallValues, $body->ranks, $dto->rownamesPerformanceTable);

    }

    function getPairsOfStrings($strings)
    {
        $pairList = [];
        for ($i = 0; $i < count($strings) - 1; $i++) {
            $pair = [$strings[$i], $strings[$i + 1]];
            $pairList[] = $pair;
        }
        return $pairList;
    }

    function getNameAttribute($object)
    {
        //    dd($object);
        return $object['name'];
    }
}
