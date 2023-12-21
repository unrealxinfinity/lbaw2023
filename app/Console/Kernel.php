<?php

namespace App\Console;

use App\Events\CreateTaskNotification;
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
                return ((new \DateTime($task->due_at)) != $tomorrow) || $task->is_notified;
            });
            foreach ($tasks as $task) {
                
                $notification = Notification::create([
                    'text' => "Task '$task->title' due tomorrow!",
                    'level' => 'High',
                    'task_id' => $task->id
                ]);
                $task->is_notified = true;
                $task->save();
                foreach ($task->assigned as $assignee) {
                    $assignee->notifications()->attach($notification->id);
                }
                event(new CreateTaskNotification("Task '$task->title' due tomorrow!",$task->project->id));
            }
        })->hourly();
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
