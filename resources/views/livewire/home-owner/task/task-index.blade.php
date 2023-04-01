<div>
    <h1 class="text-4xl font-semibold text-gray-900">Tasks</h1>
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
                    <x-table.header>Service Provider</x-table.header>
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
                                {{ $task->service_provider->username }}
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
                                <x-button.link wire:click="view({{$task->task_id}})">View</x-button.link>
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
        </div>
    </div>
</div>
