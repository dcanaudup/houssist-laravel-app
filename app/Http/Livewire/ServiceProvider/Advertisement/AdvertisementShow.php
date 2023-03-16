<?php

namespace App\Http\Livewire\ServiceProvider\Advertisement;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithPerPagination;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementData;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementOfferData;
use App\Modules\HomeOwner\Enums\AdvertisementOfferStatus;
use App\Modules\ServiceProvider\Actions\MakeOffer;
use App\Modules\ServiceProvider\Actions\StartChat;
use App\Modules\ServiceProvider\DataTransferObjects\AdvertisementOfferData;
use App\Modules\ServiceProvider\Models\AdvertisementOffer;
use App\Modules\Shared\Actions\SendMessage;
use App\Modules\Shared\DataTransferObjects\ChatData;
use App\Modules\Shared\DataTransferObjects\MessageData;
use App\Modules\Shared\DataTransferObjects\ViewChatData;
use App\Modules\Shared\Models\Advertisement;
use App\Modules\Shared\Models\Chat;
use Livewire\Component;

class AdvertisementShow extends Component
{
    use WithCachedRows, WithPerPagination;

    public ?ViewAdvertisementOfferData $viewAdvertisementOfferData = null;

    public AdvertisementOfferData $advertisementOfferData;

    public ViewAdvertisementData $advertisementData;

    public ViewChatData $viewChatData;

    public MessageData $messageData;

    public ChatData $chatData;

    public $attachments;

    public $featured;

    public function mount(Advertisement $advertisement)
    {
        $advertisement->load('media', 'home_owner');
        $this->featured = $advertisement->getMedia('advertisement-featured');
        $this->attachments = $advertisement->getMedia('advertisement-attachments');
        $this->advertisementData = ViewAdvertisementData::from($advertisement);
        $this->advertisementOfferData = AdvertisementOfferData::initialize();
        $this->chatData = ChatData::initialize();

        if ($advertisementOffer = AdvertisementOffer::where('advertisement_id', $advertisement->advertisement_id)
            ->with('service_provider')
            ->where('user_id', auth()->id())
            ->first()) {
            $this->viewAdvertisementOfferData = ViewAdvertisementOfferData::from($advertisementOffer);
        }

        $this->initializeChat();
    }

    public function render()
    {
        return view('livewire.service-provider.advertisement.advertisement-show');
    }

    public function makeOffer(MakeOffer $makeOffer, StartChat $startChat)
    {
        $this->validate([
            'advertisementOfferData.payment_rate' => 'required|numeric|min:0',
        ]);

        $this->advertisementOfferData->user_id = auth()->id();
        $this->advertisementOfferData->offer_date = now();
        $this->advertisementOfferData->advertisement_id = $this->advertisementData->advertisement_id;
        $this->advertisementOfferData->status = AdvertisementOfferStatus::PENDING;
        $offer = $makeOffer->execute($this->advertisementOfferData);
        $this->chatData->advertisement_id = $this->advertisementData->advertisement_id;
        $this->chatData->advertisement_offer_id = $offer->advertisement_offer_id;
        $chat = $startChat->execute($this->chatData);
        $this->advertisementOfferData = AdvertisementOfferData::initialize();
        $this->chatData = ChatData::initialize();
        $offer->load('service_provider');

        $this->viewAdvertisementOfferData = ViewAdvertisementOfferData::from($offer);

        $chat->load('messages');
        $this->viewChatData = ViewChatData::from($chat);
        $this->messageData = MessageData::initialize();

        $this->dispatchBrowserEvent('notify', ['message' => 'Offer Sent! You can now chat with the home owner.']);
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
        if ($chat = Chat::where('advertisement_id', $this->advertisementData->advertisement_id)
            ->where('advertisement_offer_id', $this->viewAdvertisementOfferData?->advertisement_offer_id)
            ->with('messages')
            ->first()) {
            $this->viewChatData = ViewChatData::from($chat);
            return $chat;
        }

        return null;
    }
}
