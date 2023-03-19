<div>
    <h1 class="text-4xl font-semibold text-gray-900">Support Tickets</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text placeholder="Search Tickets..." type="search"/>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Reference Number</x-table.header>
                    <x-table.header>Subject</x-table.header>
                    <x-table.header>Type</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Created</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($supportTickets as $supportTicket)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$supportTicket->sid}}">
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
                                    href="{{route('shared.support-tickets.show', $supportTicket->support_ticket_id)}}">
                                    View
                                </x-label.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="10" class="text-center">
                                <p class="text-gray-500">No Advertisements created yet.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
