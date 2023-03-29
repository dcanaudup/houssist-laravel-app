<div>
    <h1 class="text-4xl font-semibold text-gray-900">Deposits</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filter.search" placeholder="Search Deposits..." type="search"/>
            </div>

            <div class="space-x-2 flex items-center">
                <x-button.primary wire:click="create"><x-icon.plus/> New</x-button.primary>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Amount</x-table.header>
                    <x-table.header>Deposit Type</x-table.header>
                    <x-table.header>Transaction Date</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($deposits as $deposit)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$deposit->id}}">
                            <x-table.cell>
                                <span class="text-cool-gray-900 font-medium">{{ $deposit->amount }} </span>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $deposit->deposit_type }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $deposit->transaction_date_for_humans }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $deposit->status }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-button.link wire:click="view({{$deposit->deposit_id}})">View</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="5" class="text-center">
                                <p class="text-gray-500">No deposits found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>
    </div>

    <!-- Create Deposit Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showCreateModal" max-width="4xl">
            <x-slot name="title">New Deposit</x-slot>

            <x-slot name="content">
                <x-input.group for="amount" label="Amount" :error="$errors->first('newDeposit.amount')">
                    <x-input.text wire:model="newDeposit.amount" id="amount" placeholder="Amount" type="number"/>
                </x-input.group>

                <x-input.group for="deposit_type" label="Deposit Type" :error="$errors->first('newDeposit.deposit_type')">
                    <x-input.select wire:model="newDeposit.deposit_type" id="deposit_type" placeholder="Select an option...">
                        @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\Shared\Enums\DepositType::class)->toArray() as $option)
                            <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
                <x-input.group for="deposit_type" label="Proof of deposit" :error="$errors->first('attachments')">
                    <x-input.filepond wire:model="attachments"></x-input.filepond>
                </x-input.group>

                <x-input.group for="user_remarks" label="Remarks" :error="$errors->first('newDeposit.user_remarks')">
                    <x-input.textarea wire:model="newDeposit.user_remarks" id="user_remarks" placeholder="Remarks" />
                </x-input.group>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showCreateModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>

    <!-- View Deposit Modal -->
    <x-modal.dialog wire:model.defer="showViewModal" max-width="4xl">
        <x-slot name="title">View Deposit</x-slot>

        <x-slot name="content">
            <x-label.group label="User">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->user->username }}</dd>
            </x-label.group>
            <x-label.group label="Amount">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->amount }}</dd>
            </x-label.group>

            <x-label.group label="Deposit Type">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->deposit_type }}</dd>
            </x-label.group>

            <x-label.group label="Status">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->status }}</dd>
            </x-label.group>

            <x-label.group label="Proof of deposit">
                {{$viewDeposit?->media[0]}}
            </x-label.group>

            <x-label.group label="Remarks">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->user_remarks }}</dd>
            </x-label.group>

            <x-label.group label="Admin Remarks">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->admin_remarks }}</dd>
            </x-label.group>

            <x-label.group label="Latest Transaction Date">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewDeposit?->latest_transaction_date_time_for_humans }}</dd>
            </x-label.group>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="$set('showViewModal', false)">Close</x-button.secondary>
            @if($viewDeposit?->status == \App\Modules\Shared\Enums\DepositStatus::Pending)
                <x-button.danger onclick="confirm('Are you sure you want to reject this deposit?') || event.stopImmediatePropagation()" wire:click="reject({{$viewDeposit?->deposit_id}})">Reject</x-button.danger>
                <x-button.primary onclick="confirm('Are you sure you want to approve this deposit?') || event.stopImmediatePropagation()" wire:click="approve({{$viewDeposit?->deposit_id}})">Approve</x-button.primary>
            @endif
        </x-slot>
    </x-modal.dialog>

    <!-- Confirm Cancel Modal -->
    <form wire:submit.prevent="cancel">
        <x-modal.confirmation wire:model.defer="showConfirmCancelModal" max-width="4xl">
            <x-slot name="title">Confirm Cancellation</x-slot>

            <x-slot name="content">
                <p>Are you sure you want to cancel this deposit?</p>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showConfirmCancelModal', false)">Cancel</x-button.secondary>
                <x-button.danger wire:click="cancel({{$viewDeposit?->deposit_id}})">Confirm</x-button.danger>
            </x-slot>
        </x-modal.confirmation>
    </form>
</div>