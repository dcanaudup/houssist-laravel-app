<div>
    <h1 class="text-4xl font-semibold text-gray-900">My Tasks</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filter.search" placeholder="Search Tasks..." type="search"/>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Title</x-table.header>
                    <x-table.header>Home Owner</x-table.header>
                    <x-table.header>From</x-table.header>
                    <x-table.header>To</x-table.header>
                    <x-table.header>Payment Rate Type</x-table.header>
                    <x-table.header>Rate</x-table.header>
                    <x-table.header>Status</x-table.header>
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
                                {{ $task->advertisement->job_payment_type }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->advertisement_offer->payment_rate }}
                            </x-table.cell>

                            <x-table.cell>
                                {{ $task->status }}
                            </x-table.cell>

                            <x-table.cell>
                                <x-button.link wire:click="view({{$task}})">View</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="8" class="text-center">
                                <p class="text-gray-500">No tasks found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>
</div>
