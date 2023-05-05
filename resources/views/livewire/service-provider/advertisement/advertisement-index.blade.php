<div>
    <h1 class="text-4xl font-semibold text-gray-900">Available Ads</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="grid grid-cols-3 gap-2">
            <div class="col-span-1">
                <x-input.multi-select
                    wire:model.lazy="filters.categories"
                    id="categories"
                    name="categories"
                    placeholder="Filter by category..."
                    label="Categories"
                    :items="$categories"
                    selected="selectedCategories"
                >
                </x-input.multi-select>
            </div>
            <div class="col-span-1 justify-center my-auto">
                <x-search.date
                    id="filters.job_date_time"
                    name="filters.job_date_time"
                    placeholder="Task Date"
                    ref="job_date_time"
                    dateFormat="Y-m-d"
                    mode="range"
                />
            </div>
            <div class="col-span-1 justify-center my-auto">
                <x-button.link wire:click="resetFilters">Reset Filters</x-button.link>
            </div>
        </div>
        <div class="bg-white rounded-lg">
            <div class="mx-auto max-w-2xl py-8 px-4 sm:py-12 sm:px-6 lg:max-w-7xl lg:px-8">
                <h2 class="sr-only">Advertisements</h2>

                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @forelse($advertisements as $advertisement)
                        <a href="{{route('service-provider.advertisements.show', $advertisement->advertisement_id)}}" class="group">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-w-7 xl:aspect-h-8">
                                {{ $advertisement->media->first() }}
                            </div>
                            <h3 class="mt-4 text-sm text-gray-700">{{ $advertisement->title }}</h3>
                            <p class="mt-1 text-lg font-medium text-gray-900">{{ $advertisement->payment_rate }} ({{ $advertisement->job_payment_type }})</p>
                        </a>
                    @empty
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900">No advertisements available</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
