@extends('layouts.app')
@section('content')
    <div>
        <h1>Reference Table</h1>
        <h3 class="instruction">Drag and drop to reorder</h3>
        <div class="container">
            <div class="column">
                <x-filament::card height="100%">
                    <x-laravel-blade-sortable::sortable
                        group="people"
                        wire:onSortOrderChange="handleOnSortOrderChanged"
                    >
                        @foreach($names as $name)
                            <x-filament::card class="sortable_card">

                                <x-laravel-blade-sortable::sortable-item sort-key="{{ $name }}">
                                    {{ $name }}
                                </x-laravel-blade-sortable::sortable-item>
                            </x-filament::card>
                        @endforeach
                    </x-laravel-blade-sortable::sortable>
                </x-filament::card>
            </div>
            <div class="icon_wrapper">
                <x-filament::icon
                    alias="panels::topbar.global-search.field"
                    class="h-8 w-8 text-gray-500 dark:text-gray-400"
                >
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5"></path>
                    </svg>
                </x-filament::icon>
            </div>
            <div class="column">
                <x-filament::card height="100%">
                    <x-laravel-blade-sortable::sortable
                        group="people"
                    >
                        @foreach($names as $name)
                            <x-filament::card class="sortable_card">

                                <x-laravel-blade-sortable::sortable-item sort-key="{{ $name }}">
                                    {{ $name }}
                                </x-laravel-blade-sortable::sortable-item>
                            </x-filament::card>
                        @endforeach
                    </x-laravel-blade-sortable::sortable>
                </x-filament::card>
            </div>
        </div>
    </div>


@endsection

<script>
    const laravelBladeSortable = () => {
        return {
            name: '',
            sortOrder: [],
            animation: 150,
            ghostClass: '',
            dragHandle: null,
            group: null,
            allowSort: true,
            allowDrop: true,

            wireComponent: null,
            wireOnSortOrderChange: null,

            init() {
                this.sortOrder = this.computeSortOrderFromChildren()

                window.Sortable.create(this.$refs.root, {
                    handle: this.dragHandle,
                    animation: this.animation,
                    ghostClass: this.ghostClass,
                    group: {
                        name: this.group,
                        put: this.allowDrop,
                    },
                    sort: this.allowSort,
                    onSort: evt => {
                        const previousSortOrder = [...this.sortOrder]
                        this.sortOrder = this.computeSortOrderFromChildren()

                        if (!this.wireComponent) {
                            return
                        }

                        const from = evt?.from?.dataset?.name
                        const to = evt?.to?.dataset?.name
                        this[this.wireOnSortOrderChange](
                            this.sortOrder,
                            previousSortOrder,
                            this.name,
                            from,
                            to,
                        )
                    },
                });
            },

            computeSortOrderFromChildren() {
                return [].slice.call(this.$refs.root.children)
                    .map(child => child.dataset.sortKey)
                    .filter(sortKey => sortKey)
            }
        }
    }
</script>


