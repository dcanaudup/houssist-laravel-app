<div>
    <h1 class="text-4xl font-semibold text-gray-900">Support Ticket Thread {{$supportTicket->reference_number}}</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                @if($supportTicket->status === \App\Modules\Shared\Enums\SupportTicketStatus::Open)
                <x-button.default onclick="confirm('Are you sure you want to close in favor of the home owner?') || event.stopImmediatePropagation()" wire:click="closeForHomeOwner({{$supportTicket->home_owner_id}})">Close and refund home owner</x-button.default>
                <x-button.primary onclick="confirm('Are you sure you want to close in favor of the service provider?') || event.stopImmediatePropagation()" wire:click="closeForServiceProvider({{$supportTicket->service_provider_id}})">Close and release funds to service provider</x-button.primary>
                @endif
            </div>

            <div class="space-x-2 flex items-center">
                <x-label.button href="{{route('admin.support-tickets')}}">Back</x-label.button>
            </div>
        </div>

        <div class="bg-white py-6 px-4 sm:p-6 rounded-lg">
            <div class="flex-1 overflow-y-auto">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="space-y-6">
                        @foreach($supportTicket->messages as $message)
                            <div
                                @class([
                                    "px-4 py-2 rounded-lg shadow-md space-y-8",
                                    "bg-gray-50" => $message->user->id == auth()->user()->id,
                                    "bg-indigo-50" => $message->user->id == $supportTicket->home_owner_id,
                                    "bg-indigo-600" => $message->user->id == $supportTicket->service_provider_id,
                                ])
                            >
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="ml-4">
                                        <div @class([
                                            'text-sm font-medium',
                                            "text-white" => $message->user->id == $supportTicket->service_provider_id,
                                            "text-gray-700" => $message->user->id == auth()->user()->id || $message->user->id == $supportTicket->home_owner_id,
                                        ])>{{ $message->user->username }}</div>
                                        <div @class([
                                            'text-sm',
                                            "text-gray-50" => $message->user->id == $supportTicket->service_provider_id,
                                            "text-gray-500" => $message->user->id == auth()->user()->id || $message->user->id == $supportTicket->home_owner_id,
                                        ])>{{ date_for_humans($message->created_at) }}</div>
                                    </div>
                                </div>
                                <p
                                    @class([
                                        'text-sm',
                                        "text-white" => $message->user->id == $supportTicket->service_provider_id,
                                        "text-gray-700" => $message->user->id == auth()->user()->id || $message->user->id == $supportTicket->home_owner_id,
                                    ])
                                    class="">{{$message->message}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex-shrink-0">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    @if($supportTicket->status === \App\Modules\Shared\Enums\SupportTicketStatus::Open)
                    <form wire:submit.prevent="save">
                        <div class="flex">
                            <textarea
                                wire:model="newSupportTicketMessageData.message"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" placeholder="Enter your message"></textarea>
                            <button type="submit" class="ml-4 px-4 py-2 rounded-md font-medium bg-indigo-600 text-white hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500">Send</button>
                        </div>
                    </form>
                    @else
                        <div class="rounded-md bg-indigo-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1 md:flex md:justify-between">
                                    <p class="text-sm text-indigo-700">This ticket is now closed.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
