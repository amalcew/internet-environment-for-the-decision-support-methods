<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;

class ReferenceTable extends Component
{
    public $names;
    public $selected;

    protected string $view = 'components.reference-table-component';
    /**
     * Create a new component instance.
     */
    public function __construct($names, $selected)
    {
        $this->names = $names;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.reference-table-component');
    }

}
