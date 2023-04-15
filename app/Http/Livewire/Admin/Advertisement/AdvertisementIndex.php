<?php

namespace App\Http\Livewire\Admin\Advertisement;

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

    public function getRowsQueryProperty()
    {
        $query = Advertisement::query()
            ->join('users', 'users.id', '=', 'advertisements.user_id')
            ->when($this->filters['search'] ?? null, fn($query, $search) => $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "{$search}%")
                    ->orWhere('description', 'like', "{$search}%")
                    ->orWhere('username', 'like', "{$search}%");
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

    public function render()
    {
        return view('livewire.admin.advertisement.advertisement-index', [
            'advertisements' => $this->rows,
        ]);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }
}
