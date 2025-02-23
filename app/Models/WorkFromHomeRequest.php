<?php

namespace App\Models;

use App\WorkFromHomeStatus;
use Illuminate\Database\Eloquent\Model;

class WorkFromHomeRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'status' => WorkFromHomeStatus::class,
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
