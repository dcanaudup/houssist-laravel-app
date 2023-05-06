<div>
    <h1 class="text-4xl font-semibold text-gray-900">My Tasks</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model.debouce.300ms="filters.search" placeholder="Search Tasks..." type="search"/>
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
                    <x-table.header>Home Owner</x-table.header>
                    <x-table.header>Rating</x-table.header>
                    <x-table.header sortable wire:click="sortBy('advertisements.created_at')" :direction="$sorts['advertisements.created_at'] ?? null">From</x-table.header>
                    <x-table.header>To</x-table.header>
                    <x-table.header>Payment Details</x-table.header>
                    <x-table.header sortable wire:click="sortBy('tasks.status')" :direction="$sorts['tasks.status'] ?? null">Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($tasks as $task)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$task->task_id}}">
                            <x-table.cell>
                                <span class="text-cool-gray-900 font-medium">{{ $task->advertisement->title }} </span>
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->home_owner->username }}
                            </x-table.cell>

                            <x-table.cell>
                                @if($task->rating > 0)
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
                                {{ $task->advertisement->start_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->advertisement->end_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                <p><span class="font-medium">Method:</span> {{ $task->payment_method }}</p>
                                <p><span class="font-medium">Type:</span> {{ $task->advertisement->job_payment_type }}</p>
                                <p><span class="font-medium">Rate:</span> <span class="inline-flex items-center rounded-full bg-green-500 px-3 py-0.5 text-sm font-bold text-white">{{ $task->advertisement_offer->payment_rate }}</span></p>
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->status }}
                            </x-table.cell>

                            <x-table.cell>
                                <x-button.link wire:click="view({{$task->task_id}})">View</x-button.link>
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

        <!-- View Task Modal -->
        <x-modal.dialog wire:model.defer="showTaskModal" max-width="4xl">
            <x-slot name="title">View Task</x-slot>

            <x-slot name="content">
                <x-label.group label="Title">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->advertisement->title }}</dd>
                </x-label.group>

                <x-label.group label="Home Owner">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->home_owner->username }}</dd>
                </x-label.group>

                <x-label.group label="Status">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->status }}</dd>
                </x-label.group>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="closeView">Close</x-button.secondary>
                @if($viewTask?->status->canBeCompleted())
                    <x-button.primary onclick="confirm('Are you sure you want to complete this task?') || event.stopImmediatePropagation()" wire:click="completeTask({{$viewTask->task_id}})">Complete Task</x-button.primary>
                @endif
            </x-slot>
        </x-modal.dialog>
    </div>
</div>
