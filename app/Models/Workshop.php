<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Workshop extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'slug', 'description', 'conditions', 'cover', 'questions'];
    protected $guarded = [];
    protected $casts = [
        'conditions' => 'array',
        'questions' => 'array',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function path()
    {
        return $this->belongsTo(Path::class, 'path_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function attendees()
    {
        return $this->hasMany(Attendees::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluate::class);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
