<div>
    <h1 class="text-4xl font-semibold text-gray-900">KYC Requests</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text wire:model="filter.search" placeholder="Search Deposits..." type="search"/>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Name</x-table.header>
                    <x-table.header>Email</x-table.header>
                    <x-table.header>Mobile Number</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Date Requested</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($kycRequests as $kycRequest)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$kycRequest->id}}">
                            <x-table.cell>
                                {{ $kycRequest->user->name }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $kycRequest->user->email }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $kycRequest->user->mobile_number }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $kycRequest->status }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ diff_for_humans($kycRequest->created_at) }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-button.link wire:click="view({{$kycRequest->id}})">View</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-center">
                                <p class="text-gray-500">No KYC requests found.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>

        <!-- View Modal -->
        <x-modal.dialog wire:model.defer="showViewModal" max-width="4xl">
            <x-slot name="title">View KYC Request</x-slot>

            <x-slot name="content">
                <x-label.group label="Name">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewKycRequest?->user->name }}</dd>
                </x-label.group>

                <x-label.group label="Email">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewKycRequest?->user->email }}</dd>
                </x-label.group>

                <x-label.group label="Mobile Number">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewKycRequest?->user->mobile_number }}</dd>
                </x-label.group>

                <x-label.group label="Address">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewKycRequest?->user->address }}</dd>
                </x-label.group>

                <x-label.group label="Valid ID" :borderless="true">
                    {{$viewKycRequest?->getMedia('kyc.valid_id')[0]}}
                </x-label.group>

                <x-label.group label="Valid ID Number">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewKycRequest?->valid_id_number }}</dd>
                </x-label.group>

                <x-label.group label="Selfie w/ Valid ID" :borderless="true">
                    {{$viewKycRequest?->getMedia('kyc.selfie')[0]}}
                </x-label.group>

                <x-label.group label="NBI Clearance" :borderless="true">
                    {{$viewKycRequest?->getMedia('kyc.nbi_clearance')[0]}}
                </x-label.group>

                <x-label.group label="Other Supporting Documents" :borderless="true">
                    @if($supportingDocuments = $viewKycRequest?->getMedia('kyc.supporting_documents'))
                        @foreach($supportingDocuments as $supportingDocument)
                            {{$supportingDocument}}
                        @endforeach
                    @endif
                </x-label.group>

                <x-label.group label="User Remarks">
                    <dd class="mt-1 text-sm text-gray-900">{{ $viewKycRequest?->user_remarks }}</dd>
                </x-label.group>

                <form wire:submit.prevent="submit" id="kyc-form">
                    <x-input.group for="updateKycRequestData.admin_remarks" label="My Remarks" :error="$errors->first('updateKycRequestData.admin_remarks')">
                        <x-input.textarea wire:model="updateKycRequestData.admin_remarks" id="updateKycRequestData.admin_remarks" placeholder="Remarks" />
                    </x-input.group>

                    <x-input.group for="updateKycRequestData.status" label="Status" :error="$errors->first('updateKycRequestData.status')">
                        <x-input.select wire:model="updateKycRequestData.status" id="updateKycRequestData.status" placeholder="Select an option...">
                            @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\ServiceProvider\Enums\KycStatus::class)->toArray() as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </form>
            </x-slot>

            <x-slot name="footer">
                <x-button.secondary wire:click="$set('showViewModal', false)">Cancel</x-button.secondary>

                <x-button.primary type="submit" form="kyc-form">Save</x-button.primary>
            </x-slot>
        </x-modal.dialog>
    </div>
</div>
