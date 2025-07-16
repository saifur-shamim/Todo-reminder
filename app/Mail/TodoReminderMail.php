<?php
namespace App\Mail;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TodoReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function build()
    {
        try {
            Log::info('Building TodoReminderMail for: ' . $this->todo->id);

            $response = Http::get('https://jsonplaceholder.typicode.com/posts');
            Log::info('API response status: ' . $response->status());

            $titles = collect($response->json())->take(10)->pluck('title');

            $csv = fopen('php://temp', 'r+');
            fputcsv($csv, ['Title']);
            foreach ($titles as $title) {
                fputcsv($csv, [$title]);
            }
            rewind($csv);
            $csvContent = stream_get_contents($csv);
            fclose($csv);

            return $this->subject('🔔 Todo Reminder')
                ->view('emails.todo_reminder')
                ->with(['todo' => $this->todo])
                ->attachData($csvContent, 'titles.csv', [
                    'mime' => 'text/csv',
                ]);

        } catch (\Throwable $e) {
            Log::error('TodoReminderMail build failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            throw $e; // rethrow for queue to register the failure
        }
    }
}
