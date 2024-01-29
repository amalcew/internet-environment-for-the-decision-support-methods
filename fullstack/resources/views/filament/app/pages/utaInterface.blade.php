<x-filament-panels::page>
    <x-filament::section>
        <style>

            .row:after {
                content: "";
                display: table;
                clear: both;
            }

            .instruction {
                margin: 20px 0;
                font-weight: bold;
                vertical-align: middle;
                text-align: center;
                font-size: x-large;
            }

            .column_icon {
                margin: 0 auto;
                vertical-align: middle;
            }

            #multi_column {
                display: grid;
                grid-template-columns: 45% 10% 45%;
                width: 100%;
            }

            .sortable_card {
                margin: 20px 0;
            }

            .icon_wrapper {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            #single_column {
                margin: 0 auto;
                width: 50%;
                padding: 10px;
            }

            .secondary-button {
                width: 30%;
                padding: 20px;
                border-radius: 14px;
                margin: 20px auto;
            }

            .button-container {
                display: flex;

            }

            .row-container {
                display: table;
                width: 100%;
                table-layout: fixed;
                border-spacing: 10px;
            }

            .column-table-cell {
                display: table-cell;
                text-align: center;
            }

            .grid-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
            }

            .grid-cell {
                text-align: center;
                margin: 20px;
                font-size: 20px;
            }

            .chart-title {
                text-align: center;
                font-size: 20px;
                margin: 20px;
            }

            .badge-text {
                font-size: 16px;
                margin: 6px;
                text-align: center;
            }

        </style>
        <x-slot name="heading">
            {{ $widgetData["custom_title"] }}
        </x-slot>
        <x-reference-table-component :names="$widgetData['list']" :selected="$widgetData['selected']"/>
        <div class="button-container">
            <x-filament::button size="xl" class="secondary-button"
                                wire:click="generateFinalRanking( {{ $widgetData['uta_id'] }} )">
                {{ __('Generate final ranking') }}
            </x-filament::button>
        </div>

    </x-filament::section>
    <x-filament::section>
        <x-final-ranking-component :ranking="$widgetData['final_ranking']"/>
    </x-filament::section>
    <x-filament::section>
        <div class="grid-container">
            @foreach ($widgetData['chart_data'] as $key => $value)
                <div class="grid-cell">
                    <h3 class="chart-title">{{ $key }}</h3>
                    @livewire(\App\Filament\App\Pages\UtaChart::class, ['chart_data' => $value, 'chart_title' => $key])
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-panels::page>
