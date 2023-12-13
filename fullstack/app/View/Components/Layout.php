<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;

class Layout extends Component
{
    public $title;
    public $content;

    public function __construct($title)
    {
        $this->title= $title;
    }

    public function render()
    {
        return view('components.layout');
    }
}
