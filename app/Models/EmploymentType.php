<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class EmploymentType extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name', 'description'];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
