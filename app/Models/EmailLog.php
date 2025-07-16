<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'to',
        'subject',
        'body',
        'sent_at',
        'todo_id',
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }
}
