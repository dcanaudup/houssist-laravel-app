<?php

namespace App\Console\Commands;

use App\Modules\ServiceProvider\Enums\TaskStatus;
use App\Modules\ServiceProvider\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ChangeTaskStatusToInProgressCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-task-status-to-in-progress-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change task status to in progress according to start date time';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $recordsUpdated = Task::query()
            ->join('advertisements', 'advertisements.advertisement_id', '=', 'tasks.advertisement_id')
            ->where('tasks.status', TaskStatus::WAITING)
            ->update([
                'tasks.status' => TaskStatus::IN_PROGRESS,
            ]);

        $this->info("{$recordsUpdated} " . Str::plural('record', $recordsUpdated) . " updated");
    }
}
