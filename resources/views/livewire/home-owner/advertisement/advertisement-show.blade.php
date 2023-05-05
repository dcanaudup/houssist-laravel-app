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

            <x-label.group label="Payment Method">
                <dd class="mt-1 text-sm text-gray-900">{{ $advertisementData->payment_method }}</dd>
            </x-label.group>

            <x-label.group label="Categories">
                @foreach($tags as $tag)
                    <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-0.5 text-sm font-medium text-indigo-800">{{$tag->name}}</span>
                @endforeach
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

            @if($advertisementData->status === \App\Modules\HomeOwner\Enums\AdvertisementStatus::PENDING)
                <x-label.group label="Actions">
                    <x-button.danger onclick="confirm('Are you sure you want to cancel this ad?') || event.stopImmediatePropagation()" wire:click="cancel">Cancel</x-button.danger>
                </x-label.group>
            @endif

            <x-label.group label="Images">
                <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach($featured as $featuredImage)
                        {{$featuredImage->img()->attributes(['class' => 'group object-contain h-48 w-48'])}}
                    @endforeach
                    @foreach($attachments as $attachment)
                        {{$attachment->img()->attributes(['class' => 'object-contain h-48 w-48'])}}
                    @endforeach
                </div>
            </x-label.group>

            <h2 class="text-2xl font-semibold text-gray-900 py-4">Offers</h2>

            <x-table>
                <x-slot:head>
                    <x-table.header>Service Provider</x-table.header>
                    <x-table.header>Offer</x-table.header>
                    <x-table.header class="hidden md:table-cell">Latest Offer Date</x-table.header>
                    <x-table.header class="hidden md:table-cell">Contact Date</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($advertisement_offers as $advertisement_offer)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$advertisement_offer->advertisement_offer_id}}">
                            <x-table.cell>
                                <div class="flex items-center xl:col-span-1">
                                {{ $advertisement_offer->service_provider->rating }}
                                <svg
                                    class="text-yellow-400 h-5 w-5"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                                <p class="ml-2 text-cool-gray-900 font-medium">{{ $advertisement_offer->service_provider->username }}</p>
                                </div>
                                <x-label.link href="#" wire:click="showRatingsModal({{$advertisement_offer->service_provider->id}})">View Reviews</x-label.link>

                            </x-table.cell>

                            <x-table.cell>
                                {{ $advertisement_offer->payment_rate }}
                            </x-table.cell>

                            <x-table.cell class="hidden md:table-cell">
                                {{ diff_for_humans($advertisement_offer->offer_date) }}
                            </x-table.cell>

                            <x-table.cell class="hidden md:table-cell">
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

            <x-modal.dialog wire:model.lazy.defer="showRatingsModal" max-width="4xl">
                <x-slot name="title">{{$serviceProvider?->username}}</x-slot>
                <x-slot name="content">
                    <h2 class="text-lg font-medium text-gray-900 mb-5">
                    @if($serviceProvider?->rating !== 0.0)
                        <div class="flex items-center">
                            {{$serviceProvider?->rating}}
                            <svg class="text-yellow-400 h-5 w-5 flex-shrink-0 ml-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    @else
                        No ratings yet.
                    @endif
                    </h2>
                    <h2 class="text-lg font-medium text-gray-900">Recent reviews</h2>
                    <div class="mt-6 space-y-10 divide-y divide-gray-200 border-b border-t border-gray-200 pb-10">
                        @forelse ($reviews as $review)
                            <div class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
                                <div class="lg:col-span-8 lg:col-start-5 xl:col-span-9 xl:col-start-4 xl:grid xl:grid-cols-3 xl:items-start xl:gap-x-8">
                                    <div class="flex items-center xl:col-span-1">
                                        <div class="flex items-center">
                                            <svg
                                                @class([
                                                    'h-5 w-5 flex-shrink-0',
                                                    'text-yellow-400' => $review->rating >= 1,
                                                    'text-gray-200' => $review->rating < 1,
                                                ])
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                            </svg>
                                            <svg
                                                @class([
                                                    'h-5 w-5 flex-shrink-0',
                                                    'text-yellow-400' => $review->rating >= 2,
                                                    'text-gray-200' => $review->rating < 2,
                                                ])
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                            </svg>
                                            <svg
                                                @class([
                                                    'h-5 w-5 flex-shrink-0',
                                                    'text-yellow-400' => $review->rating >= 3,
                                                    'text-gray-200' => $review->rating < 3,
                                                ])
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                            </svg>
                                            <svg
                                                @class([
                                                    'h-5 w-5 flex-shrink-0',
                                                    'text-yellow-400' => $review->rating >= 4,
                                                    'text-gray-200' => $review->rating < 4,
                                                ])
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                            </svg>
                                            <svg
                                                @class([
                                                    'h-5 w-5 flex-shrink-0',
                                                    'text-yellow-400' => $review->rating >= 5,
                                                    'text-gray-200' => $review->rating < 5,
                                                ])
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">{{$review->rating}}<span class="sr-only"> out of 5 stars</span></p>
                                    </div>

                                    <div class="mt-4 lg:mt-6 xl:col-span-2 xl:mt-0">
                                        <h3 class="text-sm font-medium text-gray-900">{{$review->review_title}}</h3>

                                        <div class="mt-3 space-y-6 text-sm text-gray-500">
                                            <p>{{$review->review}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center text-sm lg:col-span-4 lg:col-start-1 lg:row-start-1 lg:mt-0 lg:flex-col lg:items-start xl:col-span-3">
                                    <p class="font-medium text-gray-900">{{$review->home_owner->username}}</p>
                                    <time datetime="2021-01-06" class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:ml-0 lg:mt-2 lg:border-0 lg:pl-0">{{date_for_humans($review->reviewed_at)}}</time>
                                </div>
                            </div>
                        @empty
                            No Ratings Yet.
                        @endforelse
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <x-button.secondary wire:click="$set('showRatingsModal', false)">Close</x-button.secondary>
                </x-slot>
            </x-modal.dialog>
        </div>
    </div>
</div>
