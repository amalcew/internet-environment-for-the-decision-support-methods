<div class="TOJA">
    <x-laravel-blade-sortable::sortable
        name="my_name"
        wire:onSortOrderChange="handleSortOrderChange">
        <x-laravel-blade-sortable::sortable-item sort-key="jason">
            Jason
        </x-laravel-blade-sortable::sortable-item>
        <x-laravel-blade-sortable::sortable-item sort-key="andres">
            Andres
        </x-laravel-blade-sortable::sortable-item>
        <x-laravel-blade-sortable::sortable-item sort-key="matt">
            Matt
        </x-laravel-blade-sortable::sortable-item>
        <x-laravel-blade-sortable::sortable-item sort-key="james">
            James
        </x-laravel-blade-sortable::sortable-item>
    </x-laravel-blade-sortable::sortable>
</div>
