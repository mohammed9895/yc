<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class TmakonUser extends Model
{
    use HasTranslations;

    public $translatable = [
        'name',
        'job',
    ];
    protected $guarded = [];

    protected $casts = [
        'social_media_links' => 'array',
    ];

    public function tmakonCategory(): BelongsTo
    {
        return $this->belongsTo(TmakonCategory::class);
    }

}
