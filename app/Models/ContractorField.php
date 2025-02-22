<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ContractorField extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected $guarded = [];

    public function contractors(): HasMany
    {
        return $this->hasMany(Contractor::class);
    }
}
