<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ContractorCategory extends Model
{
    use HasTranslations;

    protected $guarded = [];

     public $translatable = ['name', 'description'];
    public function contractors(): HasMany
    {
        return $this->hasMany(Contractor::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
