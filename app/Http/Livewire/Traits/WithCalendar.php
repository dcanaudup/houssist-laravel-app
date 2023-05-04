<?php

namespace App\Http\Livewire\Traits;

use App\Modules\ServiceProvider\Models\Task;

trait WithCalendar
{
    public function getCalendarQueryProperty()
    {
        return Task::with('advertisement', 'service_provider:id,username', 'home_owner:id,username')
            ->where($this->userTypeId, auth()->id());
    }

    public function getCalendarProperty()
    {
        return $this->cache(function () {
            $events = [];
            $tasks = $this->calendarQuery->get();
            foreach ($tasks as $task) {
                $events[] = [
                    'id' => $task->task_id,
                    'title' => $task->advertisement->title,
                    'start' => $task->advertisement->start_date_time->toDateTimeString(),
                    'end' => $task->advertisement->end_date_time->toDateTimeString(),
                    'display' => 'block',
                ];
            }

            return $events;
        });
    }
}
