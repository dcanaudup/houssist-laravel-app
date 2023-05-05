<div>
    <h1 class="text-4xl font-semibold text-gray-900">My Offers</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Hide @endif Advanced Search...</x-button.link>
            </div>
        </div>

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
                <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.group inline for="filters.status" label="Status">
                            <x-input.select wire:model.lazy="filters.status" id="filters.status" placeholder="Select an option...">
                                @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\HomeOwner\Enums\AdvertisementOfferStatus::class)->toArray() as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="w-1/2 pl-2 space-y-4">
                        <x-input.group inline for="filters.payment_method" label="Offer Date">
                            <x-search.date
                                id="filters.offer_date"
                                name="filters.offer_date"
                                placeholder="Task Date"
                                ref="offer_date"
                                dateFormat="Y-m-d"
                                mode="range"
                            />
                        </x-input.group>
                        <div class="pt-2">
                            <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Title</x-table.header>
                    <x-table.header>Home Owner</x-table.header>
                    <x-table.header sortable wire:click="sortBy('advertisement_offers.offer_date')" :direction="$sorts['advertisement_offers.offer_date'] ?? null">Offer Date</x-table.header>
                    <x-table.header>Ad Rate</x-table.header>
                    <x-table.header>My Offer</x-table.header>
                    <x-table.header sortable wire:click="sortBy('advertisement_offers.status')" :direction="$sorts['advertisement_offers.status'] ?? null">Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($advertisementOffers as $offer)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$offer->advertisement_offer_id}}">
                            <x-table.cell>
                                <span class="text-cool-gray-900 font-medium">{{ $offer->advertisement->title }} </span>
                            </x-table.cell>

                            <x-table.cell>
                                {{ $offer->advertisement->home_owner->username }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $offer->offer_date}}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $offer->advertisement->payment_rate }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $offer->payment_rate }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $offer->status }}
                            </x-table.cell>

                            <x-table.cell>
                                <x-label.link href="{{route('service-provider.advertisements.show', $offer->advertisement_id)}}">View</x-label.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="9" class="text-center">
                                <p class="text-gray-500">No Results found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
