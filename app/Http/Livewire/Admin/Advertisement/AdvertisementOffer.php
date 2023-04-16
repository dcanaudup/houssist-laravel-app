<?php

namespace App\Http\Livewire\Admin\Advertisement;

use App\Modules\ServiceProvider\Models\AdvertisementOffer as AdvertisementOfferModel;
use App\Modules\Shared\Models\Chat;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

/**
 * @property AdvertisementOfferModel $viewAdvertisementOffer
 * @property Chat $chat
 */
class AdvertisementOffer extends Component
{
    public $advertisement_offer_id;

    public function getViewAdvertisementOfferProperty()
    {
        return $this->advertisement_offer_id ? Cache::remember(AdvertisementOfferModel::CACHE_KEY.$this->advertisement_offer_id, 300, function () {
            return AdvertisementOfferModel::with('service_provider', 'advertisement.home_owner')->findOrFail($this->advertisement_offer_id);
        }) : null;
    }

    public function getChatProperty()
    {
        return $this->advertisement_offer_id ? Cache::remember(Chat::CACHE_KEY.$this->advertisement_offer_id, 300, function () {
            return Chat::with('messages')->where('advertisement_offer_id', $this->advertisement_offer_id)->firstOrFail();
        }) : null;
    }

    public function mount(int $advertisement, int $offer)
    {
        $this->advertisement_offer_id = $offer;
    }

    public function render()
    {
        return view('livewire.admin.advertisement.advertisement-offer', [
            'viewAdvertisementOffer' => $this->viewAdvertisementOffer,
            'chat' => $this->chat,
        ]);
    }

    public function updateChat()
    {
        return $this->getChatProperty();
    }
}
