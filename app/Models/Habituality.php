<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Habituality extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'user_id',
        'weapon_id',
        'date_time',
        'event_id',
        'location_id',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class);
    }

    public function ammunitionHabitualities()
    {
        return $this->hasMany(AmmunitionHabituality::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
}
