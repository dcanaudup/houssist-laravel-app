<div>
    <h1 class="text-4xl font-semibold text-gray-900">Advertisements</h1>
    <div class="py-4 space-y-4">
        <!-- Top Bar -->
        <div class="flex justify-between">
            <div class="w-2/4 flex space-x-4">
                <x-input.text placeholder="Search Deposits..." type="search"/>
            </div>

            <div class="space-x-2 flex items-center">
                <x-button.primary wire:click="create"><x-icon.plus/> New</x-button.primary>
            </div>
        </div>

        <!-- Table -->
        <div class="flex-col space-y-4">
            <x-table>
                <x-slot:head>
                    <x-table.header>Title</x-table.header>
                    <x-table.header>Description</x-table.header>
                    <x-table.header>Address</x-table.header>
                    <x-table.header>From</x-table.header>
                    <x-table.header>To</x-table.header>
                    <x-table.header>Payment Type</x-table.header>
                    <x-table.header>Rate</x-table.header>
                    <x-table.header>Date Created</x-table.header>
                    <x-table.header>Status</x-table.header>
                    <x-table.header>Actions</x-table.header>
                </x-slot:head>

                <x-slot:body>
                    @forelse($advertisements as $advertisement)
                        <x-table.row class="bg-cool-gray-200" wire:key="row-{{$advertisement->id}}">
                            <x-table.cell>
                                {{ $advertisement->title }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement->description }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement->address }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ date_for_humans($advertisement->start_date_time) }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ date_for_humans($advertisement->end_date_time) }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement->job_payment_type }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement->payment_rate }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ diff_for_humans($advertisement->created_at) }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $advertisement->status }}
                            </x-table.cell>
                            <x-table.cell>
                                <x-label.link href="{{route('home-owner.advertisements.show', $advertisement->advertisement_id)}}">View</x-label.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="10" class="text-center">
                                <p class="text-gray-500">No Advertisements created yet.</p>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot:body>
            </x-table>
        </div>

        <!-- Create Advertisment Modal -->
        <form wire:submit.prevent="save">
            <x-modal.dialog wire:model.lazy.defer="showCreateModal" max-width="4xl">
                <x-slot name="title">New Advertisement</x-slot>

                <x-slot name="content">
                    <x-input.group for="title" label="Title" :error="$errors->first('newAdvertisement.title')">
                        <x-input.text wire:model.lazy="newAdvertisement.title" id="title" placeholder="Title" type="text"/>
                    </x-input.group>

                    <x-input.group for="description" label="Description" :error="$errors->first('newAdvertisement.description')">
                        <x-input.textarea wire:model.lazy="newAdvertisement.description" id="description" placeholder="Description" />
                    </x-input.group>

                    <x-input.group for="address" label="Address" :error="$errors->first('newAdvertisement.address')">
                        <x-input.textarea wire:model.lazy="newAdvertisement.address" id="address" placeholder="Address" />
                    </x-input.group>

                    <x-input.group for="start_date_time" label="From" :error="$errors->first('newAdvertisement.start_date_time')">
                        <x-input.date
                            wire:model.lazy="newAdvertisement.start_date_time"
                            id="start_date_time"
                            placeholder="From"
                            ref="start_date_time"
                            dateFormat="Y-m-d H:i:ss"
                            enableTime="true"
                        />
                    </x-input.group>

                    <x-input.group for="end_date_time" label="To" :error="$errors->first('newAdvertisement.end_date_time')">
                        <x-input.date
                            wire:model.lazy="newAdvertisement.end_date_time"
                            id="end_date_time"
                            placeholder="To"
                            ref="end_date_time"
                            dateFormat="Y-m-d H:i:ss"
                            enableTime="true"
                        />
                    </x-input.group>

                    <x-input.group for="job_payment_type" label="Job Payment Type" :error="$errors->first('newAdvertisement.job_payment_type')">
                        <x-input.select wire:model.lazy="newAdvertisement.job_payment_type" id="job_payment_type" placeholder="Select an option...">
                            @foreach (\Spatie\LaravelOptions\Options::forEnum(\App\Modules\HomeOwner\Enums\JobPaymentType::class)->toArray() as $option)
                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="payment_rate" label="Payment Rate" :error="$errors->first('newAdvertisement.payment_rate')">
                        <x-input.text wire:model.lazy="newAdvertisement.payment_rate" id="payment_rate" placeholder="Payment Rate" type="number"/>
                    </x-input.group>

                    <x-input.group for="featured" label="Featured Image" :error="$errors->first('featured')">
                        <x-input.filepond wire:model="featured"></x-input.filepond>
                    </x-input.group>

                    <x-input.group for="attachments" label="Attachments" :error="$errors->first('attachments')">
                        <x-input.filepond wire:model="attachments" multiple></x-input.filepond>
                    </x-input.group>
                </x-slot>

                <x-slot name="footer">
                    <x-button.secondary wire:click="$set('showCreateModal', false)">Cancel</x-button.secondary>

                    <x-button.primary type="submit">Save</x-button.primary>
                </x-slot>
            </x-modal.dialog>
        </form>
    </div>
</div>
