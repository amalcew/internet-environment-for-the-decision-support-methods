<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FinalRankingComponent extends Component
{
    public $ranking;
    public $title = '';
    public $content = '';

    protected string $view = 'components.final-ranking-component';

    /**
     * Create a new component instance.
     */
    public function __construct($ranking)
    {
        $this->ranking = $ranking;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.final-ranking-component');
    }

}
