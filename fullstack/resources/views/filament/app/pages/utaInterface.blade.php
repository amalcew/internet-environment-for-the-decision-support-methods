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
        </style>
        <x-slot name="heading">
            {{ $widgetData["custom_title"] }}
        </x-slot>
        <x-reference-table-component :names="$widgetData['list']" :selected="$widgetData['selected']"/>
        <div class="button-container">
            <x-filament::button size="xl" class="secondary-button">
                Generate final ranking
            </x-filament::button>
        </div>

    </x-filament::section>
    <x-filament::section>
        <x-final-ranking-component :ranking="$widgetData['final_ranking']"/>
    </x-filament::section>
</x-filament-panels::page>
