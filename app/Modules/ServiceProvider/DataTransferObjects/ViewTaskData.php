<?php

namespace App\Modules\ServiceProvider\DataTransferObjects;

use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementData;
use App\Modules\HomeOwner\DataTransferObjects\ViewAdvertisementOfferData;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;
use App\Modules\Shared\DataTransferObjects\ViewUserData;
use Carbon\Carbon;
use Livewire\Wireable;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class ViewTaskData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        public readonly Lazy|ViewUserData $service_provider,
        public readonly int $task_id,
        public readonly Lazy|ViewUserData $home_owner,
        public readonly Lazy|ViewAdvertisementData $advertisement,
        public readonly Lazy|ViewAdvertisementOfferData $advertisement_offer,
        public readonly TaskStatus $status,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at
    ) {
    }

    public static function fromModel(Task $task): static
    {
        return new self(
            Lazy::whenLoaded('service_provider', $task, fn () => ViewUserData::fromModel($task->service_provider)),
            $task->task_id,
            Lazy::whenLoaded('home_owner', $task, fn () => ViewUserData::fromModel($task->home_owner)),
            Lazy::whenLoaded('advertisement', $task, fn () => ViewAdvertisementData::from($task->advertisement))->defaultIncluded(),
            Lazy::whenLoaded('advertisement_offer', $task, fn () => ViewAdvertisementOfferData::fromModel($task->advertisement_offer)),
            $task->status,
            $task->created_at,
            $task->updated_at,
        );
    }
}
