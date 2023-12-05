<?php

namespace App\Infolists\Components;

use Filament\Infolists\Components\Entry;
use Illuminate\Contracts\View\View;

class Electre1sGraph extends Entry
{
//    public $foo = 'Hello world!';


//    public array $graphData = [
//        'nodes'=> [
//            ['id'=>1, 'name'=>'A'],
//            ['id'=>2, 'name'=>'B'],
//            ['id'=>3, 'name'=>'C'],
//        ],
//        'links'=> [
//            ['source'=>1, 'target'=>2],
//            ['source'=>2, 'target'=>3],
//            ['source'=>3, 'target'=>1],
//        ]
//    ];

    public $title = '';
    protected string $view = 'infolists.components.electre1s-graph';

}
