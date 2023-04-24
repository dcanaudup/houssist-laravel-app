<?php

namespace App\Modules\HomeOwner\Actions;

use App\Aggregates\WalletAggregateRoot;
use App\Modules\HomeOwner\DataTransferObjects\NewAdvertisementData;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use App\Modules\HomeOwner\Enums\PaymentMethod;
use App\Modules\Shared\Enums\WalletTransactionType;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class CreateAdvertisement
{
    public function execute(NewAdvertisementData $newAdvertisement): Advertisement
    {
        DB::beginTransaction();
        if ($newAdvertisement->payment_method === PaymentMethod::WALLET) {
            WalletAggregateRoot::retrieve(auth()->user()->wallet->uuid)
                ->subtractMoney(
                    $this->calculateTotalPayment($newAdvertisement),
                    WalletTransactionType::Payment->value,
                    Str::uuid()->toString()
                )
                ->persist();
        }

        $advertisement = new Advertisement($newAdvertisement->except('categories')->toArray());
        $advertisement->save();

        $advertisement->attachTags(Tag::whereIn('id', $newAdvertisement->categories)->get());

        $advertisement->addMediaFromDisk($newAdvertisement->featured)
            ->toMediaCollection('advertisement-featured');

        foreach ($newAdvertisement->attachments as $attachment) {
            $advertisement->addMediaFromDisk($attachment)
                ->toMediaCollection('advertisement-attachments');
        }

        DB::commit();

        return $advertisement;
    }

    private function calculateTotalPayment(NewAdvertisementData $newAdvertisementData): float
    {
        return match ($newAdvertisementData->job_payment_type) {
            JobPaymentType::HOURLY => $this->calculateHourlyRate($newAdvertisementData),
            JobPaymentType::DAILY => $this->calculateDailyRate($newAdvertisementData),
            JobPaymentType::FIXED => $newAdvertisementData->payment_rate,
        };
    }

    private function calculateHourlyRate(NewAdvertisementData $newAdvertisementData): float
    {
        $startDate = Carbon::parse($newAdvertisementData->start_date_time);
        $endDate = Carbon::parse($newAdvertisementData->end_date_time);

        $hours = $startDate->diffInHours($endDate);

        return $hours * $newAdvertisementData->payment_rate;
    }

    private function calculateDailyRate(NewAdvertisementData $newAdvertisementData): float
    {
        $startDate = Carbon::parse($newAdvertisementData->start_date_time);
        $endDate = Carbon::parse($newAdvertisementData->end_date_time);

        $days = $startDate->diffInDays($endDate);

        return $days * $newAdvertisementData->payment_rate;
    }
}
