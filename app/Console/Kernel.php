<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Models\Task;
use App\Models\Notification;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function() {
            $tomorrow = date_add(date_time_set(new DateTime(), 0, 0), new DateInterval("P1D"));
            $tasks = Task::all();
            $tasks = array_filter($tasks, function($task) {
                return (new DateTime($task->due_at)) == $tomorrow;
            });
            foreach ($tasks as $task) {
                $notification = Notification::create([
                    'text' => "Task $task->title due tomorrow!",
                    'level' => 'High',
                    'task_id' => $task->id
                ]);

                foreach ($tasks->assigned as $assignee) {
                    $assignee->notifications()->attach($notification->id);
                }
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
