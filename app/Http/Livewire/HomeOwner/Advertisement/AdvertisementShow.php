<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithLockedPublicPropertiesTrait;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\Actions\CancelAdvertisement;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementData;
use App\Modules\HomeOwner\Enums\AdvertisementStatus;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Modules\ServiceProvider\Models\Task;
use App\Modules\Shared\Models\Advertisement;
use App\Modules\Shared\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Silber\Bouncer\BouncerFacade;

class AdvertisementShow extends Component
{
    use WithCachedRows, WithPerPagination, AuthorizesRequests, WithLockedPublicPropertiesTrait;

    public ViewAdvertisementData $advertisementData;

    /** @locked */
    public $advertisement_id;

    public $showRatingsModal = false;

    /** @locked */
    public $service_provider_id;

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

    public function getServiceProviderQueryProperty()
    {
        return User::query()
            ->where('id', $this->service_provider_id)
            ->select(['id', 'username', 'rating']);
    }

    public function getServiceProviderProperty()
    {
        if (!$this->service_provider_id) {
            return null;
        }

        return $this->cache(function () {
            return $this->serviceProviderQuery->first();
        }, 'service_provider_');
    }

    public function getReviewsQueryProperty()
    {
        return Task::where('service_provider_id', $this->service_provider_id)
            ->where('rating', '>', 0)
            ->select(['rating', 'review_title', 'review', 'reviewed_at', 'home_owner_id'])
            ->orderBy('reviewed_at', 'desc')
            ->with('home_owner:id,username');
    }

    public function getReviewsProperty()
    {
        if (!$this->service_provider_id) {
            return [];
        }

        return $this->cache(function () {
            return $this->reviewsQuery->get();
        }, 'reviews_');
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
            'serviceProvider' => $this->serviceProvider,
            'reviews' => $this->reviews,
        ]);
    }

    public function cancel(CancelAdvertisement $cancelAdvertisement)
    {
        $advertisement = Advertisement::findOrFail($this->advertisement_id);
        if ($advertisement->status !== AdvertisementStatus::PENDING) {
            $this->dispatchBrowserEvent('notify', ['message' => 'Cannot cancel this ad!']);
            return;
        }

        $user = User::with('wallet')->where('id', auth()->id())->first();
        $cancelAdvertisement->execute($advertisement, $user);

        $this->dispatchBrowserEvent('notify', ['message' => 'Ad cancelled!']);
    }

    public function showRatingsModal(int $service_provider_id)
    {
        $this->useCachedRows();
        $this->service_provider_id = $service_provider_id;
        $this->showRatingsModal = true;
    }
}
