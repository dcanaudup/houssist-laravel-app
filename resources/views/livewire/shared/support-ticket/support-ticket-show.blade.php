<div>
    <h1 class="text-4xl font-semibold text-gray-900">Support Ticket Thread {{$supportTicket->reference_number}}</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
            </div>

            <div class="space-x-2 flex items-center">
                <x-label.button href="{{route('shared.support-tickets')}}">Back</x-label.button>
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
                                    "bg-indigo-50" => $message->user->id != auth()->user()->id,
                                ])
                            >
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $message->user->username }}</div>
                                        <div class="text-sm text-gray-500">{{ date_for_humans($message->created_at) }}</div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-700">{{$message->message}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex-shrink-0">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <form wire:submit.prevent="save">
                        <div class="flex">
                            <textarea
                                wire:model="newSupportTicketMessageData.message"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="3" placeholder="Enter your message"></textarea>
                            <button type="submit" class="ml-4 px-4 py-2 rounded-md font-medium bg-indigo-600 text-white hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
