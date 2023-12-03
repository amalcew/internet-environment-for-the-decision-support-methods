<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <x-laravel-blade-sortable::scripts/>
    <script src="/resources/js/app.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="resources/css/app.css" />


    <title>UTA Interface</title>
    <style>
        {
            box-sizing: border-box;
        }
        /* Set additional styling options for the columns*/
        .column {
            float: left;

            height: 100%;
        }

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
        }

        .column_icon {
            margin: 0 auto;
            vertical-align: middle;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            width: 100%;
        }

        .sortable_card {
            margin: 20px 0;
        }

        .icon_wrapper {
            display:flex;
            justify-content:center;
            align-items:center;
        }

    </style>
    </head>
    <body>

    <x-filament-panels::page>
        <x-filament::section>

            <x-slot name="heading">
                {{ $widgetData["custom_title"] }}
            </x-slot>

            <x-reference-table-component :names="$widgetData['list']"/>
            <x-bladewind::button>Save User</x-bladewind::button>

        </x-filament::section>
    </x-filament-panels::page>

    </body>
</html>

