<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
//        Log all sql queries
//        DB::listen(function($query) {
//            Log::info(
//                $query->sql,
//                $query->bindings,
//                $query->time
//            );
//        });

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch

                ->locales(['en', 'pl']);
//                ->flags([
//                    'en' => asset('flags/england.svg'),
//                    'pl' => asset('flags/poland.svg'),
//                ])
//                    ->flagsOnly();
        });
    }
}
