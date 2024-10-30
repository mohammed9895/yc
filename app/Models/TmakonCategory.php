<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class TmakonCategory extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public $translatable = ['name'];

    protected $table = 'tmakon_categories';

    public function tmakonUsers(): HasMany
    {
        return $this->hasMany(TmakonUser::class);
    }
}
