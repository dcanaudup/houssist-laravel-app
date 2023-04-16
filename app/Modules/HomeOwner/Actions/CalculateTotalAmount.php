<?php

namespace App\Modules\HomeOwner\Actions;

use App\Modules\HomeOwner\DataTransferObjects\NewAdvertisementData;
use App\Modules\HomeOwner\Enums\JobPaymentType;
use App\Modules\Shared\Models\Advertisement;
use Illuminate\Support\Carbon;

class CalculateTotalAmount
{
    public static function calculateTotalPayment($advertisement): float
    {
        return match ($advertisement->job_payment_type) {
            JobPaymentType::HOURLY => static::calculateHourlyRate($advertisement),
            JobPaymentType::DAILY => static::calculateDailyRate($advertisement),
            JobPaymentType::FIXED => $advertisement->payment_rate,
        };
    }

    private static function calculateHourlyRate($advertisement): float
    {
        $startDate = Carbon::parse($advertisement->start_date_time);
        $endDate = Carbon::parse($advertisement->end_date_time);

        $hours = $startDate->diffInHours($endDate);

        return $hours * $advertisement->payment_rate;
    }

    private static function calculateDailyRate($advertisement): float
    {
        $startDate = Carbon::parse($advertisement->start_date_time);
        $endDate = Carbon::parse($advertisement->end_date_time);

        $days = $startDate->diffInDays($endDate);

        return $days * $advertisement->payment_rate;
    }
}
