<?php

namespace App\Http\Livewire\HomeOwner\Calendar;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Http\Livewire\Traits\WithCalendar;
use Livewire\Component;

class CalendarIndex extends Component
{
    use WithCachedRows, WithCalendar;

    public string $userTypeId = 'home_owner_id';

    public function render()
    {
        return view('livewire.shared.calendar.calendar-index', [
            'events' => $this->calendar,
        ]);
    }
}
