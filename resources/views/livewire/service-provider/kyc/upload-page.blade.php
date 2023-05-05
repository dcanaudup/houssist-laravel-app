<div>
    <h1 class="text-4xl font-semibold text-gray-900">Account Verification</h1>
    <!-- Create Deposit Modal -->
    <form wire:submit.prevent="save">
        <x-input.panel>
            <x-input.group for="name" label="Name" :error="$errors->first('name')">
                <x-input.text wire:model="name" id="name" placeholder="Full Name" />
            </x-input.group>

            <x-input.group for="mobile_number" label="Mobile Number" :error="$errors->first('mobile_number')">
                <x-input.text wire:model="mobile_number" id="mobile_number" placeholder="Mobile Number" />
            </x-input.group>

            <x-input.group for="address" label="Address" :error="$errors->first('address')">
                <x-input.textarea wire:model="address" id="address" placeholder="Address" />
            </x-input.group>

            <x-input.group for="deposit_type" label="Valid ID" :error="$errors->first('valid_id')">
                <x-input.filepond wire:model="valid_id" ref="valid_id"></x-input.filepond>
            </x-input.group>

            <x-input.group for="valid_id_number" label="Valid ID Number" :error="$errors->first('valid_id_number')">
                <x-input.text wire:model="valid_id_number" id="valid_id_number" placeholder="Valid ID Number" />
            </x-input.group>

            <x-input.group for="deposit_type" label="Selfie w/ Valid ID" :error="$errors->first('selfie')">
                <x-input.filepond wire:model="selfie" ref="selfie"></x-input.filepond>
            </x-input.group>

            <x-input.group for="deposit_type" label="NBI Clearance" :error="$errors->first('nbi_clearance')">
                <x-input.filepond wire:model="nbi_clearance" ref="nbi_clearance"></x-input.filepond>
            </x-input.group>

            <x-input.group for="deposit_type" label="Other supporting documents" :error="$errors->first('supporting_documents')">
                <x-input.filepond wire:model="supporting_documents" ref="supporting_documents"></x-input.filepond>
            </x-input.group>

            <x-input.group for="user_remarks" label="Remarks" :error="$errors->first('user_remarks')">
                <x-input.textarea wire:model="user_remarks" id="user_remarks" placeholder="Remarks" />
            </x-input.group>

            <p class="text-gray-500">By submitting your personal details, you agree to Houssist's <a href="{{route('terms.index')}}" class="font-medium text-gray-700" target="_blank">Terms and Conditions</a> and <a href="{{route('privacy.index')}}" class="font-medium text-gray-700" target="_blank">Privacy Policy</a></p>

            <x-slot:footer>
                <x-button.primary type="submit">Submit</x-button.primary>
            </x-slot:footer>
        </x-input.panel>
    </form>
</div>
