<?php

namespace App\Filament\App\Resources\ElectreOneResource\Components;

use Illuminate\Contracts\Support\Htmlable;

class ElectreLabel implements Htmlable
{

    public function __construct(private $text)
    {
    }

    public function toHtml()
    {
        return '<p style="overflow: hidden; height: 25px; text-overflow: ellipsis; max-width: 50px;">'. $this->text .'</p>';
    }
}
