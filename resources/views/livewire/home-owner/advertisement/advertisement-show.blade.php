<div>
    <h1 class="text-4xl font-semibold text-gray-900">Advertisement #{{$advertisementData->advertisement_id}}</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
            </div>

            <div class="space-x-2 flex items-center">
                <x-label.button href="{{route('home-owner.advertisements')}}">Back</x-label.button>
            </div>
        </div>

        <div class="bg-white py-6 px-4 sm:p-6 rounded-lg">
            <x-label.group label="Title">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->title }}</dd>
            </x-label.group>

            <x-label.group label="Description">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->description }}</dd>
            </x-label.group>

            <x-label.group label="Address">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->address }}</dd>
            </x-label.group>

            <x-label.group label="From">
                <dd class="mt-1 text-sm text-gray-900">{{ date_for_humans($advertisementData->start_date_time) }}</dd>
            </x-label.group>

            <x-label.group label="To">
                <dd class="mt-1 text-sm text-gray-900">{{ date_for_humans($advertisementData->end_date_time) }}</dd>
            </x-label.group>

            <x-label.group label="Payment Rate Type">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->job_payment_type }}</dd>
            </x-label.group>

            <x-label.group label="Payment Rate">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->payment_rate }}</dd>
            </x-label.group>

            <x-label.group label="Status">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->status }}</dd>
            </x-label.group>

            <x-label.group label="Images">
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach($featured as $featuredImage)
                        {{$featuredImage->img()->attributes(['class' => 'group object-contain h-48 w-48'])
    ->conversion('thumb')}}
                    @endforeach
                    @foreach($attachments as $attachment)
                        {{$attachment->img()->attributes(['class' => 'object-contain h-48 w-48'])
    ->conversion('thumb')}}
                    @endforeach
                </div>
            </x-label.group>

            <h2 class="text-2xl font-semibold text-gray-900 py-4">Offers</h2>

            <x-table>
                <x-slot:head>
                    <x-table.header>Service Provider</x-table.header>
                    <x-table.header>Offer</x-table.header>
                    <x-table.header>Offer Date</x-table.header>
                    <x-table.header>Contact Date</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($advertisement_offers as $advertisement_offer)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$advertisement_offer->advertisement_offer_id}}">
                            <x-table.cell>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement_offer->payment_rate }}
                            </x-table.cell>
                            <x-table.cell>
                            </x-table.cell>
                            <x-table.cell>
                                {{ diff_for_humans($advertisement_offer->created_at) }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement_offer->status }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-label.link href="{{route('home-owner.advertisements.offer', [$advertisementData->advertisement_id, $advertisement_offer->advertisement_offer_id])}}">View</x-label.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-center">
                                <p class="text-gray-500">No offers yet.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
