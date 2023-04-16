<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementData;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Silber\Bouncer\BouncerFacade;

class AdvertisementShow extends Component
{
    use WithCachedRows, WithPerPagination, AuthorizesRequests;

    public ViewAdvertisementData $advertisementData;

    public $advertisement_id;

    public $featured;

    public $attachments;

    public $tags;

    public function getRowsQueryProperty()
    {
        return AdvertisementOffer::query()
            ->with('service_provider')
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
        $this->authorize('home-owner-advertisements', $advertisement);
        $advertisement->load('media', 'tags');
        $this->featured = $advertisement->getMedia('advertisement-featured');
        $this->attachments = $advertisement->getMedia('advertisement-attachments');
        $this->tags = $advertisement->tags;

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
