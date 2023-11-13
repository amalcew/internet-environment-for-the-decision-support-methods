<?php

namespace App\Filament\App\Pages;

use Filament\Support\Assets\Js;
use Filament\Pages\Page;
use Filament\Support\Facades\FilamentAsset;

FilamentAsset::register([
    Js::make('external-script', 'https://d3js.org/d3.v4.min.js'),
    Js::make('graph', __DIR__ . '/../../../../resources/js/graph.js'),
]);

class GraphExample extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.app.pages.graph-example';
}
