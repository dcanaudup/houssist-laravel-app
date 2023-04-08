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
                    <x-table.header sortable wire:click="sortBy('advertisements.created_at')" :direction="$sorts['advertisements.created_at'] ?? null">From</x-table.header>
                    <x-table.header>To</x-table.header>
                    <x-table.header sortable wire:click="sortBy('payment_method')" :direction="$sorts['payment_method'] ?? null">Payment Method</x-table.header>
                    <x-table.header sortable wire:click="sortBy('job_payment_type')" :direction="$sorts['job_payment_type'] ?? null">Payment Rate Type</x-table.header>
                    <x-table.header>Rate</x-table.header>
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
                                {{ $task->advertisement->start_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->advertisement->end_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->payment_method }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->advertisement->job_payment_type }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->advertisement_offer->payment_rate }}
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
