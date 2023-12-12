<?php

namespace App\Filament\App\Pages;

use Filament\Widgets\ChartWidget;

class UtaChart extends ChartWidget
{
    public $chart_data;
    public $chart_title;

    protected function getData(): array
    {

        return [
            'datasets' => [
                [
                    'label' => $this->chart_title,
                    'data' => array_values($this->chart_data)[1],
                ]
            ],
            'labels' => array_values($this->chart_data)[0],
            'tension' => 1,
        ];

    }

    protected function getType(): string
    {
        return 'line';
    }
}
