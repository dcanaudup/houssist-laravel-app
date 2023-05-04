<?php

namespace App\Http\Livewire\ServiceProvider\Calendar;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithCalendar;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;
use Livewire\Component;

class CalendarIndex extends Component
{
    use WithCachedRows, WithCalendar;

    public string $userTypeId = 'service_provider_id';

    public function render()
    {
        return view('livewire.shared.calendar.calendar-index', [
            'events' => $this->calendar,
        ]);
    }
}
