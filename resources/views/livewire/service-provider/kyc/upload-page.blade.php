<div>
    <h1 class="text-4xl font-semibold text-gray-900">Account Verification</h1>
    <!-- Create Deposit Modal -->
    <form wire:submit.prevent="save">
        <x-input.panel>
            <x-input.group for="deposit_type" label="Valid ID" :error="$errors->first('valid_id')">
                <x-input.filepond wire:model="valid_id" ref="valid_id"></x-input.filepond>
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

            <x-slot:footer>
                <x-button.primary type="submit">Submit</x-button.primary>
            </x-slot:footer>
        </x-input.panel>
    </form>
</div>
