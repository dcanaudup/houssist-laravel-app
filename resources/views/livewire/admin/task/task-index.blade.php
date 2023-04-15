<div>
    <h1 class="text-4xl font-semibold text-gray-900">Tasks</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model.debounce.250ms="filters.search" placeholder="Search Tasks..." type="search"/>
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
                        <div class="pt-2">
                            <x-button.link wire:click="resetFilters" class="pt-2 absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                        </div>
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
                    <x-table.header>Service Provider</x-table.header>
                    <x-table.header sortable wire:click="sortBy('advertisements.created_at')" :direction="$sorts['advertisements.created_at'] ?? null">From</x-table.header>
                    <x-table.header>To</x-table.header>
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
                                {{ $task->home_owner->username }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->service_provider->username }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->start_date_time }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->end_date_time }}
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

                    <x-label.group label="Home Owner">
                        <dd class="mt-1 text-sm text-gray-900">{{ $viewTask?->home_owner->username }}</dd>
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
        </div>
    </div>
</div>
