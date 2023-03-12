<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Models\AdvertisementOffer;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementData;
use App\Modules\Shared\Models\Advertisement;
use Livewire\Component;

class AdvertisementShow extends Component
{
    use WithCachedRows, WithPerPagination;

    public ViewAdvertisementData $advertisementData;

    public $advertisement_id;

    public $featured;

    public $attachments;

    public function getRowsQueryProperty()
    {
        return AdvertisementOffer::query()
            ->where('advertisement_id', $this->advertisement_id);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function mount(Advertisement $advertisement)
    {
        $advertisement->load('media');
        $this->featured = $advertisement->getMedia('advertisement-featured');
        $this->attachments = $advertisement->getMedia('advertisement-attachments');

        $this->advertisementData = ViewAdvertisementData::from($advertisement);
        $this->advertisement_id = $advertisement->advertisement_id;
    }

    public function render()
    {
        return view('livewire.home-owner.advertisement.advertisement-show', [
            'advertisement_offers' => $this->rows,
        ]);
    }
}
