<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Hall extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'description', 'conditions'];
    protected $guarded = [];
    protected $casts = [
        'conditions' => 'array',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function scheduleExclusions()
    {
        return $this->hasMany(ScheduleExclusion::class);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
