<div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.1/Sortable.min.js"></script>
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

                        @this[this.wireOnSortOrderChange](
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
    <div>
        <h1>Reference Table</h1>
        <h3 class="instruction">Drag and drop to reorder</h3>
        <div class="container" id="multi_column">
            <div class="column">
                <x-filament::card height="100%">
                    <x-laravel-blade-sortable::sortable
                        wire:onSortOrderChange="handleSortOrderChange">
                        @foreach($names as $name)
                            <x-laravel-blade-sortable::sortable-item sort-key="{{$name['id']}}" class="sortable_card">
                                <x-filament::card >
                                    {{ $name['name'] }}
                                </x-filament::card>
                            </x-laravel-blade-sortable::sortable-item>
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
                <x-filament::card height="100%" >
                    <x-laravel-blade-sortable::sortable
                        wire:onSortOrderChange="handleSortOrderChangeSorted">
                        @foreach($selected as $selecte)
                            <x-laravel-blade-sortable::sortable-item sort-key="{{ $selecte }}" class="sortable_card">
                                <x-filament::card margin-top="100px">
                                    {{ $selecte }}
                                </x-filament::card>
                            </x-laravel-blade-sortable::sortable-item>
                        @endforeach
                    </x-laravel-blade-sortable::sortable>
                </x-filament::card>
            </div>
        </div>
    </div>
</div>
