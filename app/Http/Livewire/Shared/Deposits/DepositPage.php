<?php

namespace App\Http\Livewire\Shared\Deposits;

use App\Modules\Shared\Models\Deposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DepositPage extends Component
{
    use WithFileUploads;

    public $filter = [];
    protected $queryString = ['filter'];
    public $showCreateModal = false;
    public Deposit $newDeposit;
    public $attachments;

    protected function rules(): array
    {
        return [
            'newDeposit.amount' => 'required|numeric|min:100',
            'newDeposit.deposit_type' => 'required|in:cash,bank_transaction,gcash,maya',
            'newDeposit.user_remarks' => 'sometimes|nullable|string',
            'attachments' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }

    public function mount()
    {
        $this->initializeDeposit();
    }

    public function create()
    {
        $this->showCreateModal = true;
    }

    public function save()
    {
        $this->validate();
        DB::beginTransaction();
        $this->newDeposit->user_id = Auth::id();
        $this->newDeposit->save();

        $this->newDeposit->addMedia($this->attachments)
            ->toMediaCollection('deposits');

        DB::commit();

        $this->initializeDeposit();
        $this->showCreateModal = false;
        $this->dispatchBrowserEvent('pond-reset');

        $this->dispatchBrowserEvent('notify', ['message' => 'Deposit saved!']);
    }

    public function render()
    {
        return view('livewire.shared.deposits.deposit', [
            'deposits' => Deposit::query()->where('user_id', Auth::id())->paginate(10),
        ]);
    }

    protected function initializeDeposit()
    {
        $this->newDeposit = new Deposit(['deposit_type' => 'cash']);
        if ($this->attachments) {
            $this->removeUpload('attachments', $this->attachments);
        }
    }
}
