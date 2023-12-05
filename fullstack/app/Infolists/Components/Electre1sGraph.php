<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Entry;

class Electre1sGraph extends Entry
{
    public string $foo = 'Hello world!';
    public string $graphId = 'graph';


    public array $graphData = [
        'nodes'=> [
            ['id'=>1, 'name'=>'A'],
            ['id'=>2, 'name'=>'B'],
            ['id'=>3, 'name'=>'C'],
        ],
        'links'=> [
            ['source'=>1, 'target'=>2],
            ['source'=>2, 'target'=>3],
            ['source'=>3, 'target'=>1],
        ]
    ];


    protected string $view = 'infolists.components.electre1s-graph';
    private array $widgetData;

    public function mount($graphId, $graphData, $foo): void
    {

        $this->widgetData = [
            'id' => $graphId,
            'graphData' => json_encode($graphData, JSON_FORCE_OBJECT),
            'foo' => $foo
        ];

    }
}
