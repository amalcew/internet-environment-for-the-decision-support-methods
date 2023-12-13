<?php

namespace App\Http\Controllers;

use App\Models\Variant;
class UTAReferenceRankingController extends Controller
{
    public function index()
    {
        $variants = [
            new Variant(['name' => 'Variant 1']),
            new Variant(['name' => 'Variant 2']),
            new Variant(['name' => 'Variant 3']),
        ];
        return view('filament.app.pages.utaInterface', compact('variants'));
    }

}
