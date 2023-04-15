<?php

namespace App\Http\Livewire\Admin\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementData;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Modules\Shared\Models\Advertisement;
use Livewire\Component;

class AdvertisementShow extends Component
{
    use WithCachedRows, WithPerPagination, WithLockedPublicPropertiesTrait;

    /** @locked */
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

    public function getAdvertisementProperty()
    {
        return Advertisement::query()
            ->where('advertisement_id', $this->advertisement_id)
            ->first();
    }

    public function mount(Advertisement $advertisement)
    {
        $advertisement->load('media', 'tags');
        $this->featured = $advertisement->getMedia('advertisement-featured');
        $this->attachments = $advertisement->getMedia('advertisement-attachments');
        $this->tags = $advertisement->tags;
        $this->advertisement_id = $advertisement->advertisement_id;
    }

    public function render()
    {
        return view('livewire.admin.advertisement.advertisement-show', [
            'advertisement' => $this->advertisement,
            'advertisement_offers' => $this->rows,
        ]);
    }
}
