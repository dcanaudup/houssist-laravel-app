<div>
    <h1 class="text-4xl font-semibold text-gray-900">Withdrawals</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-button.link wire:click="toggleShowFilters">@if ($showFilters) Hide @endif Advanced Search...</x-button.link>
            </div>

            <div class="space-x-2 flex items-center">
                <x-button.primary wire:click="create"><x-icon.plus/> New</x-button.primary>
            </div>
        </div>

        <!-- Advanced Search -->
        <div>
            @if ($showFilters)
                <div class="bg-cool-gray-200 p-4 rounded shadow-inner flex relative">
                    <div class="w-1/2 pr-2 space-y-4">
                        <x-input.select wire:model.lazy="filters.withdrawal_type" id="filters.withdrawal_type" placeholder="Select an option...">
                            @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\Shared\Enums\WithdrawalType::class)->toArray() as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </x-input.select>
                        <x-search.date
                            id="filters.created_at"
                            name="filters.created_at"
                            placeholder="Transaction Date"
                            ref="created_at"
                            dateFormat="Y-m-d"
                            mode="range"
                        />
                    </div>
                    <div class="w-1/2 pl-2 space-y-4">
                        <x-button.link wire:click="resetFilters" class="absolute right-0 bottom-0 p-4">Reset Filters</x-button.link>
                    </div>
                </div>
            @endif
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Amount</x-table.header>
                    <x-table.header sortable wire:click="sortBy('withdrawal_type')" :direction="$sorts['withdrawal_type'] ?? null">Withdrawal Type</x-table.header>
                    <x-table.header sortable wire:click="sortBy('created_at')" :direction="$sorts['created_at'] ?? null">Transaction Date</x-table.header>
                    <x-table.header sortable wire:click="sortBy('status')" :direction="$sorts['status'] ?? null">Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($withdrawals as $withdrawal)
                        <x-table.row wire:loading.class.delay="opacity-50" class="bg-cool-gray-200" wire:key="row-{{$withdrawal->withdrawal_id}}">
                            <x-table.cell>
                                <span class="text-cool-gray-900 font-medium">{{ $withdrawal->amount }} </span>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $withdrawal->withdrawal_type }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ date_for_humans($withdrawal->created_at) }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $withdrawal->status }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-button.link wire:click="view({{$withdrawal->withdrawal_id}})">View</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="5" class="text-center">
                                <p class="text-gray-500">No withdrawals found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>

            <div>
                {{ $withdrawals->links() }}
            </div>
        </div>
    </div>

    <!-- Create Withdrawal Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showCreateModal" max-width="4xl">
            <x-slot name="title">New Withdrawal</x-slot>

            <x-slot name="content">
                <x-input.group for="amount" label="Amount" :error="$errors->first('newWithdrawal.amount')">
                    <x-input.text wire:model.debounce.300ms="newWithdrawal.amount" id="amount" placeholder="Amount" type="number" step="100"/>
                </x-input.group>

                <x-input.group for="withdrawal_type" label="Withdrawal Type" :error="$errors->first('newWithdrawal.withdrawal_type')">
                    <x-input.select wire:model.debounce.300ms="newWithdrawal.withdrawal_type" id="withdrawal_type" placeholder="Select an option...">
                        @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\Shared\Enums\WithdrawalType::class)->toArray() as $option)
                            <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>

                <x-input.group for="withdrawal_details" label="Details" :error="$errors->first('newWithdrawal.withdrawal_details')">
                    <x-input.textarea wire:model.debounce.300ms="newWithdrawal.withdrawal_details" id="withdrawal_details" placeholder="Please put here all relevant information based on the withdrawal type (e.g. GCASH/MAYA Account number" />
                </x-input.group>

                <x-input.group for="user_remarks" label="Remarks" :error="$errors->first('newWithdrawal.user_remarks')">
                    <x-input.textarea wire:model.debounce.300ms="newWithdrawal.user_remarks" id="user_remarks" placeholder="Remarks" />
                </x-input.group>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showCreateModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </form>

    <!-- View Withdrawal Modal -->
    <x-modal.dialog wire:model.defer="showViewModal" max-width="4xl">
        <x-slot name="title">View Withdrawal</x-slot>

        <x-slot name="content">
            <x-label.group label="Amount">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewWithdrawal?->amount }}</dd>
            </x-label.group>

            <x-label.group label="Withdrawal Type">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewWithdrawal?->withdrawal_type }}</dd>
            </x-label.group>

            <x-label.group label="Status">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewWithdrawal?->status }}</dd>
            </x-label.group>

            <x-label.group label="Remarks">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewWithdrawal?->user_remarks }}</dd>
            </x-label.group>

            <x-label.group label="Admin Remarks">
                <dd class="mt-1 text-sm text-gray-900">{{ $viewWithdrawal?->admin_remarks }}</dd>
            </x-label.group>

            <x-label.group label="Latest Transaction Date">
                <dd class="mt-1 text-sm text-gray-900">{{ date_for_humans($viewWithdrawal?->latest_transaction_date) }}</dd>
            </x-label.group>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="$set('showViewModal', false)">Close</x-button.secondary>
            @if($viewWithdrawal?->status == \App\Modules\Shared\Enums\WithdrawalStatus::Pending)
                <x-button.danger onclick="confirm('Are you sure you want to cancel this withdrawal?') || event.stopImmediatePropagation()" wire:click="cancel({{$viewWithdrawal?->withdrawal_id}})">Cancel Withdrawal</x-button.danger>
            @endif
        </x-slot>
    </x-modal.dialog>
</div>
