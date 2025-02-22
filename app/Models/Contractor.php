<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contractor extends Model
{
    protected $guarded = [];

    public function contractor_field(): BelongsTo
    {
        return $this->belongsTo(ContractorField::class);
    }

    public function contractor_category(): BelongsTo
    {
        return $this->belongsTo(ContractorCategory::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
