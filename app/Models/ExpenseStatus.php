<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ExpenseStatus extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'description'];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
