<?php

namespace App\Http\Livewire\HomeOwner\Calendar;

use App\Http\Livewire\Traits\WithCachedRows;
use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;
use Livewire\Component;

class CalendarIndex extends Component
{
    use WithCachedRows;

    public function getCalendarQueryProperty()
    {
        return Task::with('advertisement', 'service_provider:id,username')
            ->where('home_owner_id', auth()->id())
            ->whereIn('status', [TaskStatus::WAITING, TaskStatus::IN_PROGRESS]);
    }

    public function getCalendarProperty()
    {
        return $this->cache(function () {
            $events = [];
            $tasks = $this->calendarQuery->get();
            foreach ($tasks as $task) {
                $events[] = [
                    'id' => $task->task_id,
                    'title' => $task->service_provider->username . ' ' .$task->advertisement->title,
                    'start' => $task->advertisement->start_date_time->toDateTimeString(),
                    'end' => $task->advertisement->end_date_time->toDateTimeString(),
                    'display' => 'block',
                ];
            }

            return $events;
        });
    }

    public function render()
    {
        return view('livewire.shared.calendar.calendar-index', [
            'events' => $this->calendar,
        ]);
    }
}
