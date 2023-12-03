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
            $tasks = Task::all()->reject(function (Task $task) {
                $tomorrow = date_add(date_time_set(new \DateTime(), 0, 0), new \DateInterval("P1D"));
                return (new \DateTime($task->due_at)) != $tomorrow;
            });
            foreach ($tasks as $task) {
                error_log($task->title);
                $notification = Notification::create([
                    'text' => "Task '$task->title' due tomorrow!",
                    'level' => 'High',
                    'task_id' => $task->id
                ]);
                error_log($notification->id);

                foreach ($task->assigned as $assignee) {
                    error_log("hello7");
                    $assignee->notifications()->attach($notification->id);
                }
            }
        })->everySecond();
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
