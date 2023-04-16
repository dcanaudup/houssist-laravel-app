<div>
    <h1 class="text-4xl font-semibold text-gray-900">Offer #{{$viewAdvertisementOffer->advertisement_offer_id}}</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
            </div>

            <div class="space-x-2 flex items-center">
                <x-label.button
                    href="{{route('admin.advertisements.show', $viewAdvertisementOffer->advertisement_id)}}">Back
                </x-label.button>
            </div>
        </div>

        <div class="bg-white py-6 px-4 sm:p-6 rounded-lg">
            <x-label.group label="Home Owner">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewAdvertisementOffer->advertisement->home_owner->username }}</dd>
            </x-label.group>

            <x-label.group label="Service Provider">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewAdvertisementOffer->service_provider->username }}</dd>
            </x-label.group>

            <x-label.group label="Rate Offered">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewAdvertisementOffer->payment_rate }}</dd>
            </x-label.group>

            <x-label.group label="Offer Date">
                <dd class="mt-1 text-sm text-gray-900">{{ date_for_humans($viewAdvertisementOffer->offer_date) }}</dd>
            </x-label.group>

            <x-label.group label="Status">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewAdvertisementOffer->status }}</dd>
            </x-label.group>
        </div>
        <div class="bg-white py-6 px-4 sm:p-6 rounded-lg">
            <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col">
                <div
                    x-data="{ scroll: () => { $el.scrollTo(0, $el.scrollHeight); }}"
                    x-intersect="scroll()"
                    wire:poll.3s="updateChat"
                    id="messages"
                    class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch max-h-128">
                    @foreach($chat->messages as $message)
                        @if($message->user_id == $viewAdvertisementOffer->user_id)
                            <x-chat.self :message="$message->message" hint="Service Provider"/>
                        @else
                            <x-chat.other :message="$message->message" hint="Home Owner"/>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('chat', event => {
            document.getElementById('messages').scrollTo(0, document.getElementById('messages').scrollHeight);
        });
    </script>
@endpush
