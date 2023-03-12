<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Models\AdvertisementOffer;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementOfferData;
use Livewire\Component;

class AdvertisementOffers extends Component
{
    public ViewAdvertisementOfferData $view_advertisement_offer_data;

    public function mount(AdvertisementOffer $offer)
    {
        $offer->load('service_provider');
        $this->view_advertisement_offer_data = ViewAdvertisementOfferData::from($offer);
    }

    public function render()
    {
        return view('livewire.home-owner.advertisement.advertisement-offers');
    }
}
