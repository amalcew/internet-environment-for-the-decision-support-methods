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
        <h1 class="instruction">{{__('Final ranking')}}</h1>
        <div class="container">
            <div class="column" id="single_column">
                <x-filament::card>
                    <div class="row-container">
                        <div class="column-table-cell">
                            {{__('Utility')}}
                        </div>
                        <div class="column-table-cell">
                            {{__('Rank')}}
                        </div>
                        <div class="column-table-cell">
                            {{__('Variant')}}
                        </div>
                    </div>
                    <x-laravel-blade-sortable::sortable id="single_column_section"
                                                        :allow-sort="false"
                                                        :allow-drop="false"
                    >
                        @foreach($ranking as $key => $position)
                            <x-laravel-blade-sortable::sortable-item sort-key="{{ $position[2] }}"
                                                                     class="sortable_card">
                                <x-filament::card>
                                    <div class="row-container">
                                        <div class="column-table-cell">
                                            <x-filament::badge>
                                                <p class="badge-text"> {{$position[0]}}</p>
                                            </x-filament::badge>
                                        </div>
                                        <div class="column-table-cell">
                                            <x-filament::badge>
                                                <p class="badge-text"> {{$position[1]}}</p>
                                            </x-filament::badge>
                                        </div>
                                        <div class="column-table-cell">
                                            <x-filament::badge>
                                                <p class="badge-text"> {{$position[2]}}</p>
                                            </x-filament::badge>
                                        </div>
                                    </div>
                                </x-filament::card>
                            </x-laravel-blade-sortable::sortable-item>
                        @endforeach
                    </x-laravel-blade-sortable::sortable>
                </x-filament::card>
            </div>
        </div>
    </div>
</div>
