<?php

namespace App\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public function render()
    {
        return view('livewire.test-component');
    }

    public function handleSortOrderChange($sortOrder, $previousSortOrder, $name, $from, $to)
    {
        dd($sortOrder);
        // $sortOrder = new keys order
        // $previousSortOrder = keys previous order
        // $name = drop target name
        // $from = name of drop target from where the dragged/sorted item came from
        // $to = name of drop target to where the dragged/sorted item was placed
    }
}
