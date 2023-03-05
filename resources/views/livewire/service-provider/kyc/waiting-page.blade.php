<div class="bg-white rounded-md">
    <div class="py-24 px-6 sm:px-6 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Your request is being reviewed.</h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Please allow 3-5 business days for our team to respond. We will email you once there is an update on your application</p>
            <div class="mt-6">
                <x-label.group label="Name">
                    <dd class="mt-1 text-sm text-gray-900">{{ $kycRequest->user->name }}</dd>
                </x-label.group>

                <x-label.group label="Email">
                    <dd class="mt-1 text-sm text-gray-900">{{ $kycRequest->user->email }}</dd>
                </x-label.group>

                <x-label.group label="Mobile Number">
                    <dd class="mt-1 text-sm text-gray-900">{{ $kycRequest->user->mobile_number }}</dd>
                </x-label.group>

                <x-label.group label="Address">
                    <dd class="mt-1 text-sm text-gray-900">{{ $kycRequest->user->address }}</dd>
                </x-label.group>

                <x-label.group label="Valid ID" :borderless="true">
                    {{$kycRequest->getMedia('kyc.valid_id')[0]}}
                </x-label.group>

                <x-label.group label="Valid ID Number">
                    <dd class="mt-1 text-sm text-gray-900">{{ $kycRequest->valid_id_number }}</dd>
                </x-label.group>

                <x-label.group label="Selfie w/ Valid ID" :borderless="true">
                    {{$kycRequest->getMedia('kyc.selfie')[0]}}
                </x-label.group>

                <x-label.group label="NBI Clearance" :borderless="true">
                    {{$kycRequest->getMedia('kyc.nbi_clearance')[0]}}
                </x-label.group>

                <x-label.group label="Other Supporting Documents" :borderless="true">
                    @if($supportingDocuments = $kycRequest->getMedia('kyc.supporting_documents'))
                        @foreach($supportingDocuments as $supportingDocument)
                            {{$supportingDocument}}
                        @endforeach
                    @endif
                </x-label.group>

                <x-label.group label="Remarks">
                    <dd class="mt-1 text-sm text-gray-900">{{ $kycRequest->user_remarks }}</dd>
                </x-label.group>
            </div>
        </div>
    </div>
</div>
