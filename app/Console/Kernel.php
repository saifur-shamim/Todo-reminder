<?php
namespace App\Console;

use App\Console\Commands\SendTodoReminders;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        SendTodoReminders::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        Log::info('Schedule method was called');
        $schedule->command('todo:send-reminders')->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
