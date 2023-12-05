<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ReferenceTable extends Component
{
    public $names;

    protected string $view = 'components.reference-table-component';
    /**
     * Create a new component instance.
     */
    public function __construct($names)
    {
        $this->names = $names;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.reference-table-component');//, compact('name'));
    }


//    public function handleSortOrderChange($sortOrder, $previousSortOrder, $name, $from, $to)
//    {
//        dd($sortOrder);
////         $sortOrder = new keys order
////         $previousSortOrder = keys previous order
////         $name = drop target name
////         $from = name of drop target from where the dragged/sorted item came from
////         $to = name of drop target to where the dragged/sorted item was placed
//    }

}
