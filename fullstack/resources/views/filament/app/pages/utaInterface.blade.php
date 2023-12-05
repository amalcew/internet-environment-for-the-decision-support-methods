<x-filament-panels::page>
    <x-filament::section>

        <x-slot name="heading">
            {{ $widgetData["custom_title"] }}
        </x-slot>

        <x-reference-table-component :names="$widgetData['list']"/>
        <x-bladewind::button>Save User</x-bladewind::button>

    </x-filament::section>
</x-filament-panels::page>
