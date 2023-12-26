<?php

namespace App\Filament\App\Pages;

use App\Models\Uta;
use App\Models\Variant;
use App\Service\MethodService\Mappers\UTAMapper;
use App\Service\MethodService\MethodFacade;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class UTAReferenceRanking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.app.pages.utaInterface';

    protected static bool $shouldRegisterNavigation = false;

    private $min_variants_in_reference_ranking = 3;

    public $widgetData;

    public function mount(): void
    {
        $proj = Filament::getTenant();
        $variants = $proj->variants;
        $this->widgetData = [
            'custom_title' => "Create your own reference ranking",
            'list' => $variants->toArray(),
            'selected' => [],
            'final_ranking' => [],
            'chart_data' => [],
            'uta_id' => request()->record
        ];
    }

    /**
     * @param $sortOrder
     * @param $previousSortOrder
     * @param $name
     * @param $from
     * @param $to
     * @return void
     */
    public function handleSortOrderChange($sortOrder, $previousSortOrder, $name, $from, $to)
    {
        $proj = Filament::getTenant();
        $variants = $proj->variants;
        $this->widgetData['list'] = $this->getStringsByIndices($variants, $sortOrder);
        $this->widgetData['chart_data'] = [];
    }

    public function handleSortOrderChangeSorted($sortOrder, $previousSortOrder, $name, $from, $to)
    {
        $proj = Filament::getTenant();
        $variants = $proj->variants;
        $this->widgetData['selected'] = $this->getStringsByIndices($variants, $sortOrder);
        $this->widgetData['chart_data'] = [];
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

    function generateFinalRanking(Uta $uta)
    {
        if (count($this->widgetData['selected']) < $this->min_variants_in_reference_ranking) {
            Notification::make()
                ->title('Reference ranking must contain at least 3 variants')
                ->warning()
                ->send();
            return;
        }
        $nameArray = array_map(function ($object) {
            return $this->getNameAttribute($object);
        }, $this->widgetData['selected']);

        $ranking = $this->getPairsOfStrings($nameArray);
        $facade = new MethodFacade();
        $dto = (new UTAMapper())->generateDTOfromUTAModel($uta, $ranking);
        $body = $facade->getUTAData($dto, false);
        $this->widgetData['chart_data'] = $body->valueFunctions;
        $zippedArrays = $this->zipArrays($body->overallValues, $body->ranks, $dto->rownamesPerformanceTable);
        $this->widgetData['final_ranking'] = $this->sortFinalRankingByRank($zippedArrays);
    }

    function sortFinalRankingByRank($zippedArrays)
    {
        $secondColumn = array_column($zippedArrays, 1);
        array_multisort($secondColumn, SORT_ASC, $zippedArrays);
        return $zippedArrays;
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
        return $object['name'];
    }
}
