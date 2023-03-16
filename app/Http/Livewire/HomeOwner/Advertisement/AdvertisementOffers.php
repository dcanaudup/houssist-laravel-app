<?php

namespace App\Http\Livewire\HomeOwner\Advertisement;

use App\Modules\HomeOwner\Actions\AcceptOffer;
use App\Modules\HomeOwner\Actions\RejectOffer;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementOfferData;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Modules\Shared\Actions\SendMessage;
use App\Modules\Shared\DataTransferObjects\MessageData;
use App\Modules\Shared\DataTransferObjects\ViewChatData;
use App\Modules\Shared\Models\Chat;
use Livewire\Component;

class AdvertisementOffers extends Component
{
    public ViewAdvertisementOfferData $view_advertisement_offer_data;

    public ViewChatData $viewChatData;

    public MessageData $messageData;

    public function mount(AdvertisementOffer $offer)
    {
        $offer->load('service_provider');
        $this->view_advertisement_offer_data = ViewAdvertisementOfferData::from($offer);

        $this->initializeChat();
    }

    public function render()
    {
        return view('livewire.home-owner.advertisement.advertisement-offers');
    }

    public function sendMessage(SendMessage $sendMessage)
    {
        $this->validate([
            'messageData.message' => 'required|string',
        ]);

        $this->messageData->chat_id = $this->viewChatData->chat_id;
        $this->messageData->user_id = auth()->id();

        $sendMessage->execute($this->messageData);
        $this->initializeChat();
    }

    public function initializeChat()
    {
        if($this->updateChat()) {
            $this->messageData = MessageData::initialize();
            $this->messageData->chat_id = $this->viewChatData->chat_id;
            $this->messageData->user_id = auth()->id();
            $this->dispatchBrowserEvent('chat');
        }
    }

    public function updateChat(): ?Chat
    {
        if ($chat = Chat::where('advertisement_id', $this->view_advertisement_offer_data->advertisement_id)
            ->where('advertisement_offer_id', $this->view_advertisement_offer_data->advertisement_offer_id)
            ->with('messages')
            ->first()) {
            $this->viewChatData = ViewChatData::from($chat);
            return $chat;
        }

        return null;
    }

    public function acceptOffer(AcceptOffer $acceptOffer)
    {
        $acceptOffer->execute(
            $this->view_advertisement_offer_data->advertisement_id,
            $this->view_advertisement_offer_data->advertisement_offer_id
        );

        $this->dispatchBrowserEvent('notify', ['message' => 'Offer accepted successfully']);

        return redirect()->route('home-owner.advertisements');
    }

    public function rejectOffer(RejectOffer $rejectOffer)
    {
        $rejectOffer->execute($this->view_advertisement_offer_data->advertisement_offer_id);

        $this->dispatchBrowserEvent('notify', ['message' => 'Offer rejected successfully']);

        return redirect()->route('home-owner.advertisements');
    }
}
