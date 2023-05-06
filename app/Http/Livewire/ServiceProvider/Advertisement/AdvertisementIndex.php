<?php

namespace App\Http\Livewire\ServiceProvider\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\Shared\Models\Advertisement;
use Livewire\Component;
use Spatie\Tags\Tag;

class AdvertisementIndex extends Component
{
    use WithCachedRows, WithPerPagination;

    public $filters = [
        'categories' => [],
        'job_date_time' => null,
    ];

    public $categories = [];

    public $selectedCategories = [];

    public function mount()
    {
        $this->categories = \Spatie\LaravelOptions\Options::forModels(Tag::getWithType('jobCategory'))->toArray();
    }

    public function getRowsQueryProperty()
    {
        return Advertisement::join('taggables', function ($join) {
                $join->on('taggables.taggable_id', '=', 'advertisements.advertisement_id')
                    ->where('taggables.taggable_type', Advertisement::class);
            })
            ->where('status', AdvertisementStatus::PENDING)
            ->when($this->filters['categories'] ?? null, fn($query, $categories) => $query->whereIn('taggables.tag_id', $categories))
            ->when($this->filters['job_date_time'] ?? null, fn($query, $jobDateTime) => $query->where(function ($q) use ($jobDateTime) {
                $q->whereBetween('start_date_time', date_range_filter_transformer($jobDateTime))
                    ->orWhereBetween('end_date_time', date_range_filter_transformer($jobDateTime));
            }))
            ->select(['advertisements.*'])
            ->distinct()
            ->with('media');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.service-provider.advertisement.advertisement-index', [
            'advertisements' => $this->rows,
        ]);
    }

    public function resetFilters() { $this->reset('filters', 'selectedCategories'); }
}
