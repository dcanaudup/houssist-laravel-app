<?php

namespace App\Http\Livewire\ServiceProvider\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\Shared\Models\Advertisement;
use Livewire\Component;

class AdvertisementIndex extends Component
{
    use WithCachedRows, WithPerPagination;

    public function getRowsQueryProperty()
    {
        return Advertisement::query()
            ->where('status', AdvertisementStatus::PENDING)
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
}
