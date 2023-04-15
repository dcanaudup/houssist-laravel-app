<div>
    <h1 class="text-4xl font-semibold text-gray-900">Support Tickets</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model.debounce.200ms="filters.search" placeholder="Search Tickets..." type="search"/>
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
                                @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\Shared\Enums\SupportTicketStatus::class)->toArray() as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="w-1/2 pl-2 space-y-4">
                        <x-input.group inline for="filters.created_at" label="Created Date">
                            <x-search.date
                                id="filters.created_at"
                                name="filters.created_at"
                                placeholder="Task Date"
                                ref="created_at"
                                dateFormat="Y-m-d"
                                mode="range"
                            />
                        </x-input.group>
                        <div>
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
                    <x-table.header>Home Owner</x-table.header>
                    <x-table.header>Service Provider</x-table.header>
                    <x-table.header>Reference Number</x-table.header>
                    <x-table.header>Subject</x-table.header>
                    <x-table.header>Type</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Created</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($supportTickets as $supportTicket)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$supportTicket->support_ticket_id}}">
                            <x-table.cell>
                                {{ $supportTicket->home_owner }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $supportTicket->service_provider }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $supportTicket->reference_number }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $supportTicket->subject }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $supportTicket->support_ticket_type }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $supportTicket->status }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ diff_for_humans($supportTicket->created_at) }}
                            </x-table.cell>

                            <x-table.cell>
                                <x-label.link
                                    href="{{route('admin.support-tickets.show', $supportTicket->support_ticket_id)}}">
                                    View
                                </x-label.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="10" class="text-center">
                                <p class="text-gray-500">No Results Found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
