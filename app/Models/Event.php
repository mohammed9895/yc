<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public static function booted()
    {
        static::creating(function (Event $event) {
            $event->uuid = str()->uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cancelled()
    {
        return !$this->status != 3;
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }

}
