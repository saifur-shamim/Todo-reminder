<?php

namespace App\Services;

use App\Models\EmailLog;
use Carbon\Carbon;

class EmailLogger
{
    public static function log($to, $subject, $body = null, $todoId = null)
    {
        EmailLog::create([
            'to' => $to,
            'subject' => $subject,
            'body' => $body,
            'sent_at' => Carbon::now(),
            'todo_id' => $todoId,
        ]);
    }
}
