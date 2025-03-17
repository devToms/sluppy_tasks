<?php

namespace App\Console;

use App\Jobs\TaskReminderJob;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Zadanie przypomnienia, które uruchamia codziennie o północy
        $schedule->call(function () {
            // Wybierz zadania, które mają termin na dzień następny
            $tasks = Task::whereDate('due_date', Carbon::tomorrow())->get();

            foreach ($tasks as $task) {
                // Dodaj zadanie do kolejki
                TaskReminderJob::dispatch($task);
            }
        })->daily(); // Uruchamiaj codziennie
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Rejestruj polecenia Artisan
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
