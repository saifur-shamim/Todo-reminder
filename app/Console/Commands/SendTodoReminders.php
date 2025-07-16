<?php
namespace App\Console\Commands;

use App\Jobs\SendTodoEmailJob;
use App\Models\Todo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendTodoReminders extends Command
{
    protected $signature   = 'todo:send-reminders';
    protected $description = 'Send reminder emails 10 minutes before due_datetime';

    public function handle()
    {
        Log::info('SendTodoReminders is running at: ' . now());

        $now     = Carbon::now();
        $in10Min = $now->copy()->addMinutes(10);
        Log::info('Checking todos between: ' . now() . ' and ' . now()->copy()->addMinutes(10));

        // Get todos due within the next 10 minutes and not yet emailed
        $todos = Todo::where('email_sent', false)
            ->whereBetween('due_datetime', [$now, $in10Min])
            ->get();

        Log::info($todos->toArray());
        Log::info(message: "h1");
        foreach ($todos as $todo) {
            // Dispatch the queued job
            Log::info(message: "h2");

            SendTodoEmailJob::dispatch($todo);
            $this->info("Dispatched email for Todo ID: {$todo->id}");
        }

        return Command::SUCCESS;
    }
}
