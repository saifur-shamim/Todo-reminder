<?php
namespace App\Jobs;

use App\Mail\TodoReminderMail;
use App\Models\Todo;
use App\Services\EmailLogger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTodoEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Todo $todo;

    public function __construct(Todo $todo)
    {
        Log::info($todo->id);
        $this->todo = $todo;
    }
    public function handle(): void
    {
        $recipient = 'saifurshamim150@gmail.com';

        Log::info("Job running for Todo ID: {$this->todo->id}");

        Mail::to($recipient)->send(new TodoReminderMail($this->todo)); 

        $this->todo->update(['email_sent' => true]);

        EmailLogger::log(
            $recipient,
            'Todo Reminder',
            'Reminder email sent for: ' . $this->todo->title,
            $this->todo->id
        );

        Log::info("Reminder email sent and logged for Todo ID: {$this->todo->id}");
    }

}
