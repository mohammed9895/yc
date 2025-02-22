<?php

namespace App\Models;

use App\BittyCashStatus;
use Illuminate\Database\Eloquent\Model;

class BittyCashRequest extends Model
{
    protected $guarded = [];

    protected $casts = [
        'proof' => 'array',
        'status' => BittyCashStatus::class
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
