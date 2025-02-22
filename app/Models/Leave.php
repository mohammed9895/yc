<?php

namespace App\Models;

use App\LeaveStatus;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => LeaveStatus::class
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
