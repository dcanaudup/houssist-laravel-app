<?php

namespace App\Http\Livewire\ServiceProvider\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Http\Livewire\Traits\WithSorting;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use Livewire\Component;

class AdvertisementOfferIndex extends Component
{
    use WithPerPagination, WithCachedRows, WithSorting;

    public $showFilters = false;

    public $filters = [
        'status' => null,
        'offer_date' => null,
    ];

    protected $queryString = ['filters', 'sorts'];

    public function getAdvertsimentOffersQueryProperty()
    {
        return AdvertisementOffer::query()
            ->where('user_id', auth()->id())
            ->when($this->filters['offer_date'] ?? null, fn($query, $offerDate) => $query->where(function ($q) use ($offerDate) {
                $q->whereBetween('advertisement_offers.offer_date', date_range_filter_transformer($offerDate));
            }))
            ->when($this->filters['status'] ?? null, fn($query, $status) => $query->where('advertisement_offers.status', $status))
            ->with('advertisement.home_owner');
    }

    public function getAdvertisementOffersProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->advertsimentOffersQuery);
        });
    }

    public function render()
    {
        return view('livewire.service-provider.advertisement.advertisement-offer-index', [
            'advertisementOffers' => $this->advertisementOffers,
        ]);
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function resetFilters() { $this->reset('filters'); }
}
