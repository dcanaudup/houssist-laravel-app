<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\Actions\CreateAdvertisement;
use App\Modules\HomeOwner\DataTransferObjects\NewAdvertisementData;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdvertisementIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithFileUploads;

    public $showCreateModal = false;

    public NewAdvertisementData $newAdvertisement;

    public $featured = null;

    public $attachments = [];

    public function getRowsQueryProperty()
    {
        return Advertisement::query()
            ->where('user_id', auth()->id());
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function mount()
    {
        $this->newAdvertisement = NewAdvertisementData::initialize();
    }

    public function updatingNewAdvertisementJobPaymentType(&$value)
    {
        $value = JobPaymentType::from($value);
    }

    public function render()
    {
        return view('livewire.home-owner.advertisement.advertisement-index', [
            'advertisements' => $this->rows,
        ]);
    }

    public function create()
    {
        $this->showCreateModal = true;
    }

    public function save(CreateAdvertisement $createAdvertisement)
    {
        $this->validate();
        $this->newAdvertisement->user_id = auth()->id();
        $this->newAdvertisement->status = AdvertisementStatus::PENDING;
        $this->newAdvertisement->featured = $this->featured;

        foreach ($this->attachments as $attachment) {
            $this->newAdvertisement->attachments[] = $attachment;
        }

        $createAdvertisement->execute($this->newAdvertisement);

        $this->dispatchBrowserEvent('notify', ['message' => 'Advertisement successfully created!']);
        $this->newAdvertisement = NewAdvertisementData::initialize();
        $this->showCreateModal = false;
    }

    protected function rules(): array
    {
        return [
            'newAdvertisement.title' => 'required|string',
            'newAdvertisement.description' => 'required|string',
            'newAdvertisement.address' => 'required|string',
            'newAdvertisement.start_date_time' => 'required|date',
            'newAdvertisement.end_date_time' => 'required|date|after_or_equal:newAdvertisement.start_date_time',
            'newAdvertisement.job_payment_type' => ['required', new Enum(JobPaymentType::class)],
            'newAdvertisement.payment_rate' => 'required|numeric|min:0',
            'featured' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'attachments' => 'nullable',
            'attachments.*' => 'file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }
}
