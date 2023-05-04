<div>
    <h1 class="text-4xl font-semibold text-gray-900">Tasks</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model.debounce.350ms="filters.search" placeholder="Search Tasks..." type="search"/>
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
                                @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\ServiceProvider\Enums\TaskStatus::class)->toArray() as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                        <x-input.group inline for="filters.payment_method" label="Payment Method">
                            <x-input.select wire:model.lazy="filters.payment_method" id="filters.payment_method" placeholder="Select an option...">
                                @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\HomeOwner\Enums\PaymentMethod::class)->toArray() as $option)
                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                @endforeach
                            </x-input.select>
                        </x-input.group>
                    </div>
                    <div class="w-1/2 pl-2 space-y-4">
                        <x-input.group inline for="filters.payment_method" label="Task Date">
                            <x-search.date
                                id="filters.job_date_time"
                                name="filters.job_date_time"
                                placeholder="Task Date"
                                ref="job_date_time"
                                dateFormat="Y-m-d"
                                mode="range"
                            />
                        </x-input.group>
                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                    </div>
                </div>
            @endif
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Title</x-table.header>
                    <x-table.header>Service Provider</x-table.header>
                    <x-table.header>Rating</x-table.header>
                    <x-table.header sortable wire:click="sortBy('advertisements.created_at')" :direction="$sorts['advertisements.created_at'] ?? null">From</x-table.header>
                    <x-table.header>To</x-table.header>
                    <x-table.header sortable wire:click="sortBy('payment_method')" :direction="$sorts['payment_method'] ?? null">Payment Method</x-table.header>
                    <x-table.header sortable wire:click="sortBy('job_payment_type')" :direction="$sorts['job_payment_type'] ?? null">Payment Rate Type</x-table.header>
                    <x-table.header>Accepted Rate</x-table.header>
                    <x-table.header sortable wire:click="sortBy('tasks.status')" :direction="$sorts['tasks.status'] ?? null">Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($tasks as $task)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$task->task_id}}">
                            <x-table.cell>
                                <span class="text-cool-gray-900 font-medium">{{ $task->title }} </span>
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->service_provider->username }}
                            </x-table.cell>

                            <x-table.cell>
                            @if($task->status->value === 'paid' && $task->rating === 0)
                                <x-button.link wire:click="rate({{$task->task_id}})">Rate</x-button.link>
                            @elseif($task->rating > 0)
                                <div class="flex items-center">
                                    <svg
                                        @class([
                                            'h-5 w-5 flex-shrink-0',
                                            'text-yellow-400' => $task->rating >= 1,
                                            'text-gray-200' => $task->rating < 1,
                                        ])
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg
                                        @class([
                                            'h-5 w-5 flex-shrink-0',
                                            'text-yellow-400' => $task->rating >= 2,
                                            'text-gray-200' => $task->rating < 2,
                                        ])
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg
                                        @class([
                                            'h-5 w-5 flex-shrink-0',
                                            'text-yellow-400' => $task->rating >= 3,
                                            'text-gray-200' => $task->rating < 3,
                                        ])
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg
                                        @class([
                                            'h-5 w-5 flex-shrink-0',
                                            'text-yellow-400' => $task->rating >= 4,
                                            'text-gray-200' => $task->rating < 4,
                                        ])
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                    <svg
                                        @class([
                                            'h-5 w-5 flex-shrink-0',
                                            'text-yellow-400' => $task->rating >= 5,
                                            'text-gray-200' => $task->rating < 5,
                                        ])
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @else
                                Not Yet Rated
                            @endif
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->start_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->end_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->payment_method }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->job_payment_type }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->advertisement_offer->payment_rate }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->status }}
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center space-x-2">
                                <x-button.link wire:click="view({{$task->task_id}})">View</x-button.link>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="9" class="text-center">
                                <p class="text-gray-500">No Results Found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>

            <!-- View Task Modal -->
            <x-modal.dialog wire:model.defer="showTaskModal" max-width="4xl">
                <x-slot name="title">View Task</x-slot>

                <x-slot name="content">
                    <x-label.group label="Title">
                        <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->advertisement->title }}</dd>
                    </x-label.group>

                    <x-label.group label="Service Provider">
                        <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->service_provider->username }}</dd>
                    </x-label.group>

                    <x-label.group label="Status">
                        <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->status }}</dd>
                    </x-label.group>
                </x-slot>

                <x-slot name="footer">
                    <x-button.secondary wire:click="closeView">Close</x-button.secondary>
                    @if($viewTask?->status === \App\Modules\ServiceProvider\Enums\TaskStatus::COMPLETED)
                        <x-button.primary onclick="confirm('Are you sure you want to release payment for this task?') || event.stopImmediatePropagation()" wire:click="releasePayment({{$viewTask->task_id}})">Release Payment</x-button.primary>
                        <x-button.danger wire:click="openDispute">File Dispute</x-button.danger>
                    @endif
                </x-slot>
            </x-modal.dialog>

            <!-- File Dispute Modal -->
            <form wire:submit.prevent="fileDispute">
                <x-modal.dialog wire:model.defer="showDisputeModal" max-width="4xl">
                    <x-slot name="title">File Dispute</x-slot>

                    <x-slot name="content">
                        <input type="hidden" value="{{$viewTask?->task_id}}" name="task_id"/>

                        <x-input.group for="message" label="Message" :error="$errors->first('newSupportTicketData.message.message')">
                            <x-input.textarea wire:model="newSupportTicketData.message.message" id="message" placeholder="Message" />
                        </x-input.group>

                        <x-input.group for="attachments" label="Attachments" :error="$errors->first('attachments')">
                            <x-input.filepond wire:model="attachments" id="attachments" multiple></x-input.filepond>
                        </x-input.group>
                    </x-slot>

                    <x-slot name="footer">
                        <x-button.secondary wire:click="$set('showDisputeModal', false)">Close</x-button.secondary>
                        <x-button.primary onclick="confirm('Are you sure you want to submit a dispute for this task?') || event.stopImmediatePropagation()" type="submit">Submit</x-button.primary>
                    </x-slot>
                </x-modal.dialog>
            </form>

            <!-- Rate Modal -->
            <form wire:submit.prevent="submitRating">
            <x-modal.dialog wire:model.defer="showDoRateModal" max-width="4xl">
                <x-slot name="title">Rate Service Provider</x-slot>
                <x-slot name="content">
                    <x-input.group for="message" label="Rating" :error="$errors->first('newSupportTicketData.message.message')">
                        <div class="flex items-center">
                            <!-- Active: "text-yellow-400", Inactive: "text-gray-200" -->
                            <label for="star1">
                                <input class="hidden" type="radio" wire:model="rating" id="star1" name="rating" value="1">
                                <svg
                                    @class([
                                        'hover:cursor-pointer h-5 w-5 flex-shrink-0',
                                        'text-yellow-400' => $rating >= 1,
                                        'text-gray-200' => $rating < 1,
                                    ])
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                            </label>
                            <label for="star2">
                                <input class="hidden" type="radio" wire:model="rating" id="star2" name="rating" value="2">
                                <svg
                                    @class([
                                        'hover:cursor-pointer h-5 w-5 flex-shrink-0',
                                        'text-yellow-400' => $rating >= 2,
                                        'text-gray-200' => $rating < 2,
                                    ])
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                            </label>
                            <label for="star3">
                                <input class="hidden" type="radio" wire:model="rating" id="star3" name="rating" value="3">
                                <svg
                                    @class([
                                        'hover:cursor-pointer h-5 w-5 flex-shrink-0',
                                        'text-yellow-400' => $rating >= 3,
                                        'text-gray-200' => $rating < 3,
                                    ])
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                            </label>
                            <label for="star4">
                                <input class="hidden" type="radio" wire:model="rating" id="star4" name="rating" value="4">
                                <svg
                                    @class([
                                        'hover:cursor-pointer h-5 w-5 flex-shrink-0',
                                        'text-yellow-400' => $rating >= 4,
                                        'text-gray-200' => $rating < 4,
                                    ])
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                            </label>
                            <label for="star5">
                                <input class="hidden" type="radio" wire:model="rating" id="star5" name="rating" value="5">
                                <svg
                                    @class([
                                        'hover:cursor-pointer h-5 w-5 flex-shrink-0',
                                        'text-yellow-400' => $rating >= 5,
                                        'text-gray-200' => $rating < 5,
                                    ])
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                </svg>
                            </label>
                        </div>
                    </x-input.group>
                    <x-input.group for="review_title" label="Title" :error="$errors->first('review_title')">
                        <x-input.text wire:model="review_title" id="review_title" placeholder="Give some title" />
                    </x-input.group>
                    <x-input.group for="message" label="Message" :error="$errors->first('reviewe')">
                        <x-input.textarea wire:model="review" id="revie" placeholder="Say something about your Service Provider" />
                    </x-input.group>
                </x-slot>

                <x-slot name="footer">
                    <x-button.secondary wire:click="closeDoRateModal">Close</x-button.secondary>
                    <x-button.primary onclick="confirm('Are you sure you want to submit this review?') || event.stopImmediatePropagation()" type="submit">Save</x-button.primary>
                </x-slot>
            </x-modal.dialog>
            </form>
        </div>
    </div>
</div>
