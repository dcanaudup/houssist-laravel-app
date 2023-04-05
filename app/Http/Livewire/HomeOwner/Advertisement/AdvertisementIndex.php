<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Modules\HomeOwner\Actions\CreateAdvertisement;
use App\Modules\HomeOwner\DataTransferObjects\NewAdvertisementData;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use App\Modules\HomeOwner\Enums\PaymentMethod;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Tags\Tag;

class AdvertisementIndex extends Component
{
    use WithCachedRows, WithPerPagination, WithFileUploads, WithSorting;

    public $showCreateModal = false;

    public $showFilters = false;

    public $filters = [
        'search' => null,
        'status' => null,
        'payment_method' => null,
        'job_date_time' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    public NewAdvertisementData $newAdvertisement;

    public $featured = null;

    public $attachments = [];

    public $categories = [];

    public $selectedCategories = [];

    public function getRowsQueryProperty()
    {
        $query = Advertisement::query()
            ->where('user_id', auth()->id())
            ->when($this->filters['search'] ?? null, fn($query, $search) => $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "{$search}%")
                    ->orWhere('description', 'like', "{$search}%");
            }))
            ->when($this->filters['status'] ?? null, fn($query, $status) => $query->where('status', $status))
            ->when($this->filters['payment_method'] ?? null, fn($query, $status) => $query->where('payment_method', $status))
            ->when($this->filters['job_date_time'] ?? null, fn($query, $jobDateTime) => $query->where(function ($q) use ($jobDateTime) {
                $q->whereBetween('start_date_time', date_range_filter_transformer($jobDateTime))
                    ->orWhereBetween('end_date_time', date_range_filter_transformer($jobDateTime));
            }));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function mount()
    {
        $this->categories = \Spatie\LaravelOptions\Options::forModels(Tag::getWithType('jobCategory'))->toArray();
        $this->newAdvertisement = NewAdvertisementData::initialize();
    }

    public function updatingNewAdvertisementJobPaymentType(&$value)
    {
        $value = JobPaymentType::from($value);
    }

    public function updatingNewAdvertisementPaymentMethod(&$value)
    {
        $value = PaymentMethod::from($value);
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
        $this->dispatchBrowserEvent('pond-reset');
        $this->newAdvertisement = NewAdvertisementData::initialize();
        $this->showCreateModal = false;
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
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

    public function resetFilters() { $this->reset('filters'); }
}
