<div>
    <h1 class="text-4xl font-semibold text-gray-900">KYC Requests</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filter.search" placeholder="Search Deposits..." type="search"/>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Name</x-table.header>
                    <x-table.header>Email</x-table.header>
                    <x-table.header>Mobile Number</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Date Requested</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($kycRequests as $kycRequest)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$kycRequest->id}}">
                            <x-table.cell>
                                {{ $kycRequest->user->name }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $kycRequest->user->email }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $kycRequest->user->mobile_number }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $kycRequest->status }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ diff_for_humans($kycRequest->created_at) }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-button.link wire:click="view({{$kycRequest}})">View</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-center">
                                <p class="text-gray-500">No KYC requests found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
